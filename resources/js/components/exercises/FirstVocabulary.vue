<template>
    <div class="question">
        <img v-if="exercise.image" :src="exercise.image" alt="" />
    </div>

    <div
        class="choices"
        :class="{
            disabled: isDisabled,
        }"
    >
        <div v-if="randomNumber == 1" class="choice">
            <label>
                <input
                    type="radio"
                    name="choice"
                    :value="exercise.vocabulary.word"
                    v-model="selectedChoice"
                    @click="
                        saveForLoopLogic(
                            exercise.vocabulary.word,
                            exercise.correct_vocabulary
                        )
                    "
                    hidden
                />
                <span>{{ exercise.vocabulary.word }}</span>
            </label>
        </div>
        <div class="choice">
            <label>
                <input
                    type="radio"
                    name="choice"
                    :value="exercise.vocabulary.word_opposite_1"
                    v-model="selectedChoice"
                    @click="
                        saveForLoopLogic(
                            exercise.vocabulary.word_opposite_1,
                            exercise.correct_vocabulary
                        )
                    "
                    hidden
                />
                <span>{{ exercise.vocabulary.word_opposite_1 }}</span>
            </label>
        </div>
        <div v-if="randomNumber == 2" class="choice">
            <label>
                <input
                    type="radio"
                    name="choice"
                    :value="exercise.vocabulary.word"
                    v-model="selectedChoice"
                    @click="
                        saveForLoopLogic(
                            exercise.vocabulary.word,
                            exercise.correct_vocabulary
                        )
                    "
                    hidden
                />
                <span>{{ exercise.vocabulary.word }}</span>
            </label>
        </div>
    </div>

    <div class="exercice-suivant" v-if="selectedChoice">
        <div
            v-if="
                selectedChoice == exercise.vocabulary.word_opposite_1 ||
                selectedChoice == exercise.correct_vocabulary
            "
        >
            <div>
                <p v-if="selectedChoice == exercise.correct_vocabulary">
                    Réussie !
                </p>
                <p v-else>Raté !</p>
            </div>

            <router-link
                :to="{
                    name: 'exercise',
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: nextExercise,
                    },
                }"
                @click="generateRandomNumber"
            >
                <span
                    v-if="
                        stockExercisesByScenario.filter(
                            (item) => item[1] === false
                        ).length === 1 &&
                        stockExercisesByScenario.some(
                            (item) =>
                                item[0] === exercise.id && item[1] === false
                        ) &&
                        countSameScenario
                    "
                >
                    Réessayer !
                </span>
                <span v-else> Suivant </span>
            </router-link>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "FirstVocabulary",
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
            //
            nextExercise: null,
            isDisabled: false,
            countSameScenario: false,
        };
    },
    mounted() {
        this.generateRandomNumber();
        this.determineNextExercise();
    },
    methods: {
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
            axios.get(`/count-with-same-scenario/${id}`).then((response) => {
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

<style scoped>
.choices {
    display: flex;
    justify-content: space-evenly;
}

div[class^="choice"] input[type="radio"] + span {
    padding: 35px;
    padding-left: 50px;
    padding-right: 50px;

    cursor: pointer;
    border-radius: 7.5px;

    font-size: 20px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
div[class^="choice"] input[type="radio"]:checked + span {
    background-color: #262626;
    color: #fbfbfb;
}

.question {
    display: flex;
    justify-content: center;

    margin-bottom: 100px;
}
.question img {
    width: 150px;
}

.disabled {
    pointer-events: none;
}
</style>
