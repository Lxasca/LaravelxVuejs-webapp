<template>
    <div class="question">
        <img v-if="exercise.image" :src="exercise.image" alt="" />
    </div>

    <div
        :class="{
            disabled:
                selectedChoice !== null && exercise.id != failedExerciseId,
        }"
        class="choices"
    >
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
        <router-link
            :to="{
                name: 'exercise',
                params: {
                    id: 1,
                    level_id: 1,
                    exercise_id: countSameScenario
                        ? failedExerciseId
                        : nextExerciseId,
                },
            }"
        >
            Suivant
        </router-link>
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
            countSameScenario: null,
        };
    },
    computed: {
        nextExerciseId() {
            this.selectedChoice = null;
            return parseInt(this.$route.params.exercise_id) + 1;
        },
        nextScenarioExerciseId() {
            this.selectedChoice = null;

            const lastExercise =
                this.stockExercisesByScenario[
                    this.stockExercisesByScenario.length - 1
                ];

            const nextExerciseId = lastExercise ? lastExercise[0] + 1 : 1;

            return nextExerciseId;
        },
        failedExerciseId() {
            this.selectedChoice = null;

            // on récup l'id du premier exercice du tableau raté
            const firstFailedExerciseId = this.stockExercisesByScenario.find(
                (item) => item[1] === false
            );

            // nextScenarioxerciseId()
            const lastExercise =
                this.stockExercisesByScenario[
                    this.stockExercisesByScenario.length - 1
                ];

            const nextExerciseId = lastExercise ? lastExercise[0] + 1 : 1;

            return firstFailedExerciseId
                ? firstFailedExerciseId[0]
                : nextExerciseId;
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
            this.countWithSameScenario();
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
        countWithSameScenario() {
            const exercise_id = this.$route.params.exercise_id;

            axios
                .get(`/count-with-same-scenario/${exercise_id}`)
                .then((response) => {
                    // On vérifie si stockExercisesByScenario contient autant de sous-tableaux qu'il y a d'exercices 'liés' (order)
                    // du même scénario qu l'exercice actuel
                    if (
                        this.stockExercisesByScenario.length === response.data
                    ) {
                        this.countSameScenario = true;
                    } else {
                        this.countSameScenario = false;
                    }
                });
        },
        redirectToFailedExercise(failedExerciseId) {
            this.selectedChoice = null;

            this.$router.push({
                name: "exercise",
                params: {
                    id: 1, // ID du niveau ou de l'exercice actuel
                    level_id: 1, // ID du niveau
                    exercise_id: failedExerciseId, // L'ID de l'exercice échoué
                },
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
