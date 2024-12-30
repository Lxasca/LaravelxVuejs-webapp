<template>
    <div class="exercise-vocabulary">
        <!-- 1. Affichage de l'image du mot à trouver, du mot dans la langue de l'apprenant, et l'image de l'écouteur -->
        <container-head :exercise="exercise"></container-head>

        <!-- 2. Affichage des choix de réponses possibles avec le mot correct et le mot faux -->
        <section class="d-flex-center">
            <div
                class="container-choices"
                :class="{
                    disabled: isDisabled,
                }"
            >
                <container-choices
                    v-if="randomNumber == 1"
                    class="choice"
                    :exercise="exercise"
                    @save-for-loop-logic="
                        saveForLoopLogic(
                            exercise.vocabulary.word,
                            exercise.correct_vocabulary
                        )
                    "
                ></container-choices>

                <div class="choice">
                    <input-choice
                        name="choice"
                        :value="exercise.vocabulary.word_opposite_1"
                        v-model="selectedChoice"
                        @click="
                            saveForLoopLogic(
                                exercise.vocabulary.word_opposite_1,
                                exercise.correct_vocabulary
                            )
                        "
                        :label="exercise.vocabulary.word_opposite_1"
                    ></input-choice>
                </div>

                <container-choices
                    v-if="randomNumber == 2"
                    class="choice"
                    :exercise="exercise"
                    @save-for-loop-logic="
                        saveForLoopLogic(
                            exercise.vocabulary.word,
                            exercise.correct_vocabulary
                        )
                    "
                ></container-choices>
            </div>
        </section>

        <!-- 3. Affichag du logo de succès ou d'échec entre les deux choix -->
        <checked-fail
            v-if="selectedChoice"
            class="d-flex-center"
            style="margin-top: -35px"
            :exercise="exercise"
            :selectedChoice="selectedChoice"
        ></checked-fail>

        <!-- 4. Affichage du bouton "Suivant" / "Réessayer" -->
        <next-exercise
            class="exercice-suivant"
            v-if="selectedChoice"
            :selectedChoice="selectedChoice"
            :exercise="exercise"
            :stockExercisesByScenario="stockExercisesByScenario"
            :nextExercise="nextExercise"
            :countSameScenario="countSameScenario"
            @generate-random-number="generateRandomNumber"
        ></next-exercise>
    </div>
</template>

<script>
import axios from "axios";
import ContainerChoices from "./partials/first_vocabulary/ContainerChoices.vue";
import InputChoice from "./partials/first_vocabulary/InputChoice.vue";
import CheckedFail from "./partials/first_vocabulary/CheckedFail.vue";
import NextExercise from "./partials/first_vocabulary/NextExercise.vue";
import ContainerHead from "./partials/first_vocabulary/ContainerHead.vue";

export default {
    name: "FirstVocabulary",
    components: {
        ContainerChoices,
        InputChoice,
        CheckedFail,
        NextExercise,
        ContainerHead,
    },
    props: {
        exercise: {
            type: Object,
            required: true,
        },
        hasFalse: {
            type: Boolean,
            required: false,
        },
        stockExercisesByScenario: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            selectedChoice: null,
            loop: null,
            randomNumber: null,
            nextExercise: null,
            isDisabled: false,
            countSameScenario: false,
        };
    },
    mounted() {
        this.generateRandomNumber();
        this.determineNextExercise();
        window.addEventListener("keydown", this.handleKeydown);
    },
    beforeDestroy() {
        window.removeEventListener("keydown", this.handleKeydown);
    },
    methods: {
        handleKeydown(event) {
            if (event.code === "Space" && this.selectedChoice !== null) {
                this.generateRandomNumber();
                this.$router.push({
                    name: "exercise",
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: this.nextExercise,
                    },
                });
            }
        },
        generateRandomNumber() {
            this.isDisabled = false;
            this.randomNumber = Math.floor(Math.random() * 2) + 1;
        },
        saveForLoopLogic(selectedValue, correctVocabulary) {
            if (selectedValue === correctVocabulary) {
                this.loop = true;
            } else {
                this.loop = false;
            }

            this.selectedChoice = selectedValue;
            this.$emit("save-for-loop-logic", this.loop);

            this.isDisabled = true;

            this.determineNextExercise();
        },
        determineNextExercise() {
            let id = this.$route.params.exercise_id;
            // Laquestion c'est : comment on dédtermine si on est dans ce cas ou non
            // uniqument dans le cas de figure ou tous les sous-tableaux de this.stockExercisesByScenario sont à true
            // sauf que si on teste juste en vu "tous", ça va considérer true quand y a un eexercice sur un à true,
            // donc faut bien récupérer le nombre total d'exercices avec un scénario précis dans une suite selon order
            // c'est seulement si stockExercisesByScenario a autant de sous-tableaux que le nombre d'exercices total de ce scenario
            // et que ces sous tableaux sont tous à true

            axios.get(`/count-with-same-type/${id}`).then((response) => {
                const totalExercises = response.data;

                if (this.stockExercisesByScenario.length !== totalExercises) {
                    // Cas normal, exercise suivant par order
                    // si l'utilisateur n'a pas encore terminé la première tentative pour chaque exercise de ce scenario
                    axios
                        .get(`/get-next-exercise-by-order/${id}`)
                        .then((response) => {
                            this.nextExercise = response.data.id;
                        });
                }

                // ici l'user a terminé (au moins) la première tentative pour chaque exercise de ce scenario
                if (this.stockExercisesByScenario.length === totalExercises) {
                    this.countSameScenario = true;
                    // Si il a réussi tous les exercices => exercise suivant
                    if (
                        this.stockExercisesByScenario.every(
                            (array) => array[1] === true
                        )
                    ) {
                        // Cas 1: On renvoie l'exercice suivant basé sur le champ 'order'
                        // L'idée ici est de trouver l'exercice qui suit celui que l'utilisateur a terminé,
                        // en respectant l'ordre défini dans le scénario.

                        axios
                            .get(`/get-next-exercise-for-next-scenario/${id}`)
                            .then((response) => {
                                this.nextExercise = response.data.id;
                            });

                        this.$emit("empty-stock");

                        // bug ça redirige vers l'exercice 2 car on finit par réussie le 1, meme si le 2 est déjà réussi
                        // ici il faut donc rediriger vers le order + 1 de l'exercice avec un scenario différent de l'exercice actuel
                    } else {
                        // Si il n'a pas réussi tous les exercices mais , on le redirige vers le premier exercice raté
                        // donc à false dans le tableau
                        const firstFailedExercise =
                            this.stockExercisesByScenario.find(
                                (array) => array[1] === false
                            );
                        if (firstFailedExercise) {
                            this.nextExercise = firstFailedExercise[0]; // l'id du premier exercice raté
                        }
                    }
                }
            });

            // Objectif : déterminer le prochain exercice en fonction de la progression de l'utilisateur

            return this.nextExercise;

            // Cas 2: L'utilisateur a terminé tous les exercices du même 'scenario'
            // Ici, on doit vérifier si l'utilisateur a terminé tous les exercices du scénario,
            // qu'ils soient réussis ou ratés. Si l'utilisateur a raté un ou plusieurs exercices,
            // il doit être redirigé vers les exercices ratés.
        },
    },
};
</script>

<style lang="scss" scoped>
.exercise-vocabulary {
    min-height: 500px;

    .container-choices {
        display: flex;
        justify-content: space-between;
        width: 800px;
        margin-top: 20px;
    }

    .exercice-suivant {
        margin-top: 40px;
    }

    .disabled {
        pointer-events: none;
    }
}
</style>
