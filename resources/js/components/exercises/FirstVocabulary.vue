<template>
    <div class="question">
        <img v-if="exercise.image" :src="exercise.image" alt="" />
    </div>

    <div
        class="choices"
        :class="{
            disabled:
                selectedChoice !== null &&
                (selectedChoice == exercise.vocabulary.word_opposite_1 ||
                    selectedChoice == exercise.correct_vocabulary) &&
                !(
                    stockExercisesByScenario.filter((item) => item[1] === false)
                        .length === 1 &&
                    stockExercisesByScenario.some(
                        (item) => item[0] === exercise.id && item[1] === false
                    ) &&
                    countSameScenario
                ),
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

            <span
                v-if="
                    stockExercisesByScenario.filter((item) => item[1] === false)
                        .length === 1 &&
                    stockExercisesByScenario.some(
                        (item) => item[0] === exercise.id && item[1] === false
                    ) &&
                    countSameScenario
                "
            >
                Réessayer !
            </span>

            <router-link
                v-else
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
                @click="generateRandomNumber"
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
            countSameScenario: null,
            randomNumber: null,
        };
    },
    mounted() {
        this.generateRandomNumber();
    },
    computed: {
        nextExerciseId() {
            this.selectedChoice = null;
            return parseInt(this.$route.params.exercise_id) + 1;
        },
        failedExerciseId() {
            const failedExercises = this.stockExercisesByScenario.filter(
                (item) => item[1] === false
            );

            const currentExerciseId = parseInt(this.$route.params.exercise_id);

            if (failedExercises.length > 0) {
                // Trouver l'index de l'exercice actuel dans les exercices ratés
                const currentFailedIndex = failedExercises.findIndex(
                    (item) => item[0] === currentExerciseId
                );

                // Si l'exercice actuel est dans la liste des exercices ratés
                if (currentFailedIndex !== -1) {
                    // Si un autre exercice raté suit dans la liste, retourner son ID
                    if (currentFailedIndex + 1 < failedExercises.length) {
                        return failedExercises[currentFailedIndex + 1][0];
                    }

                    // Sinon, recommencer à partir du premier exercice raté
                    return failedExercises[0][0];
                }

                // Si l'exercice actuel n'est pas dans les exercices ratés, retourner le premier raté
                return failedExercises[0][0];
            }

            // Si aucun exercice n'est raté, rediriger vers l'exercice du prochain scénario
            const lastExercise =
                this.stockExercisesByScenario[
                    this.stockExercisesByScenario.length - 1
                ];

            return lastExercise ? lastExercise[0] + 1 : 1;
        },
    },
    methods: {
        generateRandomNumber() {
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

            this.compareScenarioOfExercices();
            this.countWithSameScenario();
        },
        compareScenarioOfExercices() {
            const exercise_id = this.$route.params.exercise_id;

            axios
                .get(`/compare-scenario-of-exercises/${exercise_id}`)
                .then((response) => {
                    this.areScenariosEqual = response.data;
                });
        },
        countWithSameScenario() {
            const exercise_id = this.$route.params.exercise_id;

            axios
                .get(`/count-with-same-scenario/${exercise_id}`)
                .then((response) => {
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
                    id: 1,
                    level_id: 1,
                    exercise_id: failedExerciseId,
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
