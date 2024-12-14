<template>
    <div class="question">
        <img v-if="exercise.image" :src="exercise.image" alt="" />
    </div>

    <div :class="{ disabled: selectedChoice !== null }" class="choices">
        <div class="choice">
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
    </div>

    <div class="exercice-suivant" v-if="selectedChoice">
        <div v-if="selectedChoice == exercise.correct_vocabulary">
            <h5>Réussie !</h5>
        </div>
        <div v-else>
            <h5>
                Raté ! Voici la solution correcte :
                {{ exercise.correct_vocabulary }}
            </h5>
        </div>

        <br /><br />

        <!---
        si le prochain exercise a un autre scénario que l'exercice actuel, ça veut dire qu'on rentre possiblement dans la loop
        donc condition 1 : comparer le scénario du prochain exercice et l'actuel
        si différent, condition 2 :
        on récupère les items (un par un ^^) à false dans stockExercisesByScenario et on renvoie dessus
        // grâce à hasFalse et stockExercisesByScenario
        -->
        <div v-if="areScenariosEqual">
            <!-- si les scénarios sont les mêmes, on passe juste à l'exercice suivant -->
            <router-link
                :to="{
                    name: 'exercise',
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: nextExerciseId,
                    },
                }"
            >
                Suivant
            </router-link>
        </div>
        <div v-else>
            <!-- ici, on entre dans le cas où le prochain exercise à un autre scénario donc 
            il faut verifier si le tableau stockExercisesByScenario a des exercices à false ou non
            si tous les exercises sont à true, l'user passe à l'exercice suivant sans soucis
            sinon il va être redirigé sur les exercices ratés jusqu'à ce qu'il les réussissent
            -->

            <!-- si l'user a fait au moins un erreur -->
            <router-link
                v-if="hasFalse"
                :to="{
                    name: 'exercise',
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: failedExerciseId,
                    },
                }"
            >
                Suivant (boucle)
            </router-link>

            <router-link
                v-else
                :to="{
                    name: 'exercise',
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: nextExerciseId,
                    },
                }"
            >
                Suivant
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
            isDisabled: false,
            loop: null,
            areScenariosEqual: false,
        };
    },
    computed: {
        nextExerciseId() {
            this.selectedChoice = null;
            return parseInt(this.$route.params.exercise_id) + 1;
        },
        failedExerciseId() {
            // on récup l'id du premier exercice du tableau raté
            const firstFailedExerciseId = this.stockExercisesByScenario.find(
                (item) => item[1] === false
            );
            return firstFailedExerciseId ? firstFailedExerciseId[0] : null;
        },
    },
    methods: {
        saveForLoopLogic(selectedValue, correctVocabulary) {
            if (selectedValue === correctVocabulary) {
                this.loop = true;
            } else {
                this.loop = false;
            }

            this.selectedChoice = selectedValue;
            this.$emit("save-for-loop-logic", this.loop);

            this.compareScenarioOfExercices();
        },
        compareScenarioOfExercices() {
            const exercise_id = this.$route.params.exercise_id;

            axios
                .get(`/compare-scenario-of-exercises/${exercise_id}`)
                .then((response) => {
                    this.areScenariosEqual = response.data;
                    // response.data vaut True si les deux exercises ont le même scénario
                    // et False si ils ont des scénarios différents.
                });
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
