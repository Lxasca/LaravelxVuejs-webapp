<template>
    <div>
        <div :class="{ disabled: feedbackMessage }">
            <div class="question">
                <img v-if="exercise.image" :src="exercise.image" alt="" />
            </div>

            <p>
                <span v-for="(part, index) in sentenceParts" :key="index">
                    <span v-if="!part.isInput">{{ part.text }}</span>
                    <input
                        v-else
                        type="text"
                        v-model="userAnswer"
                        :placeholder="placeholderText"
                        :maxlength="exercise.correct_vocabulary.length"
                        @input="checkAnswer"
                    />
                </span>
            </p>

            <!-- nombre de lettres saisies vs. le nombre total -->
            <p>
                {{ userAnswer.length }} /
                {{ exercise.correct_vocabulary.length }}
            </p>

            <p>
                <button v-if="userAnswer.length > 0" @click="validateAnswer">
                    Valider
                </button>

                <button
                    v-if="
                        userAnswer
                            .slice(
                                0,
                                Math.ceil(
                                    exercise.correct_vocabulary.length / 3
                                )
                            )
                            .toLowerCase() !==
                        exercise.correct_vocabulary
                            .slice(
                                0,
                                Math.ceil(
                                    exercise.correct_vocabulary.length / 3
                                )
                            )
                            .toLowerCase()
                    "
                    @click="provideHintFirst"
                >
                    Aide 1/3
                </button>
                <button
                    v-if="
                        userAnswer.length >=
                            Math.ceil(
                                (exercise.correct_vocabulary.length * 1) / 3
                            ) &&
                        userAnswer
                            .slice(
                                0,
                                Math.ceil(
                                    (exercise.correct_vocabulary.length * 2) / 3
                                )
                            )
                            .toLowerCase() !==
                            exercise.correct_vocabulary
                                .slice(
                                    0,
                                    Math.ceil(
                                        (exercise.correct_vocabulary.length *
                                            2) /
                                            3
                                    )
                                )
                                .toLowerCase()
                    "
                    @click="provideHintSecond"
                >
                    Aide 2/3
                </button>
                <button
                    v-if="
                        userAnswer.length >=
                            Math.ceil(
                                (exercise.correct_vocabulary.length * 2) / 3
                            ) &&
                        userAnswer
                            .slice(
                                0,
                                Math.ceil(
                                    (exercise.correct_vocabulary.length * 3) / 3
                                )
                            )
                            .toLowerCase() !==
                            exercise.correct_vocabulary
                                .slice(
                                    0,
                                    Math.ceil(
                                        (exercise.correct_vocabulary.length *
                                            3) /
                                            3
                                    )
                                )
                                .toLowerCase()
                    "
                    @click="provideHintThird"
                >
                    Aide 3/3
                </button>
            </p>
        </div>

        <div v-if="feedbackMessage !== null">
            <div v-if="feedbackMessage">
                <p>Réussie !</p>

                <router-link
                    :to="{
                        name: 'exercise',
                        params: {
                            id: 1,
                            level_id: 1,
                            exercise_id: nextExercise,
                        },
                    }"
                >
                    Suivant (passer)
                </router-link>
            </div>
            <p v-else>Raté ! Reessayer</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "SecondVocabulary",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            userAnswer: "",
            feedbackMessage: null,
            sentenceParts: [],
            currentExercise: null,
            nextExercise: null,
        };
    },
    mounted() {
        this.resetState();
        this.updateSentenceParts();
        this.determineNextExercise();
        window.addEventListener("keydown", this.handleKeydown);
    },
    beforeDestroy() {
        window.removeEventListener("keydown", this.handleKeydown);
    },
    watch: {
        "$route.params.exercise_id": {
            immediate: true,
            handler() {
                this.resetState();
                this.updateSentenceParts();
                this.determineNextExercise();
            },
        },
    },
    computed: {
        placeholderText() {
            return "_ ".repeat(this.currentExercise.correct_vocabulary.length);
        },
    },
    methods: {
        handleKeydown(event) {
            if (this.userAnswer.length > 0) {
                if (event.code === "Space") {
                    this.validateAnswer();

                    if (this.feedbackMessage === true) {
                        this.$router.push({
                            name: "exercise",
                            params: {
                                id: 1,
                                level_id: 1,
                                exercise_id: this.nextExercise,
                            },
                        });
                    }
                }
            }
        },
        determineNextExercise() {
            let id = this.$route.params.exercise_id;

            axios.get(`/get-next-exercise-by-order/${id}`).then((response) => {
                this.nextExercise = response.data.id;
            });
        },
        checkAnswer() {
            const correctWord =
                this.currentExercise.correct_vocabulary.toLowerCase();
            if (
                this.userAnswer.toLowerCase() !==
                correctWord.slice(0, this.userAnswer.length)
            ) {
                this.userAnswer = this.userAnswer.slice(
                    0,
                    this.userAnswer.length - 1
                );
            }
        },
        validateAnswer() {
            if (
                this.userAnswer.trim().toLowerCase() ===
                this.currentExercise.correct_vocabulary.toLowerCase()
            ) {
                this.feedbackMessage = true;
            } else {
                this.feedbackMessage = false;
            }
        },
        provideHintFirst() {
            const word = this.currentExercise.correct_vocabulary;
            const hintLength = Math.ceil(word.length / 3);
            this.userAnswer = word.slice(0, hintLength);
        },
        provideHintSecond() {
            const word = this.currentExercise.correct_vocabulary;
            const hintLength = Math.ceil((word.length * 2) / 3);
            this.userAnswer = word.slice(0, hintLength);
        },
        provideHintThird() {
            const word = this.currentExercise.correct_vocabulary;
            this.userAnswer = word;
        },
        resetState() {
            this.feedbackMessage = null;
            this.userAnswer = "";
        },
        updateSentenceParts() {
            const exercise_id = parseInt(this.$route.params.exercise_id);

            axios.get(`/get-exercise/${exercise_id}`).then((response) => {
                this.currentExercise = response.data;
                const wordToReplace =
                    this.currentExercise.correct_vocabulary.toLowerCase();

                const sentence =
                    this.currentExercise.sentence.charAt(0).toUpperCase() +
                    this.currentExercise.sentence.slice(1).toLowerCase();

                const parts = sentence.split(wordToReplace);

                this.sentenceParts = parts.flatMap((part, index) => [
                    { text: part, isInput: false },
                    ...(index < parts.length - 1
                        ? [{ text: "", isInput: true }]
                        : []),
                ]);
            });
        },
    },
};
</script>

<style scoped>
input {
    border: none;
    outline: none;
    text-align: center;
}

input:focus {
    box-shadow: none;
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
