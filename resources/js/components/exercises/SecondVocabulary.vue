<template>
    <div>
        <div :class="{ disabled: feedbackMessage }">
            <!-- 1. Affichage de l'image du mot à trouver, du mot dans la langue de l'apprenant, et l'image de l'écouteur -->
            <container-head :exercise="exercise"></container-head>

            <!-- 2. Affichage de la phrase avec l'input pour le mot à trouvé -->
            <div id="section-sentenceParts">
                <p class="answer">
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
            </div>

            <!-- 3. Affichage du nombre de lettres saisies vs. le nombre total de lettres du mot à trouver -->
            <div id="section-counterLetters">
                <section id="sous-section-counterLetters">
                    <p>
                        {{ userAnswer.length }} /
                        {{ exercise.correct_vocabulary.length }}
                    </p>
                </section>
            </div>

            <div id="section-checkedFail">
                <!-- 3. Affichag du logo de succès ou d'échec entre les deux choix -->
                <checked-fail
                    v-if="feedbackMessage !== null"
                    class="d-flex-center"
                    :exercise="exercise"
                    :feedbackMessage="feedbackMessage"
                    :userAnswer="userAnswer"
                ></checked-fail>

                <section>
                    <button
                        v-if="
                            userAnswer.length <
                            Math.ceil(exercise.correct_vocabulary.length / 3)
                        "
                        @click="provideHintFirst"
                    >
                        <img
                            src="../../../images/exercises/help1.png"
                            alt="Aide 1/3"
                            width="35px"
                        />
                    </button>
                    <button
                        v-else-if="
                            userAnswer.length <
                            Math.ceil(
                                (exercise.correct_vocabulary.length * 2) / 3
                            )
                        "
                        @click="provideHintSecond"
                    >
                        <img
                            src="../../../images/exercises/help2.png"
                            alt="Aide 2/3"
                            width="35px"
                        />
                    </button>
                    <button
                        v-else-if="
                            userAnswer.length <
                            Math.ceil(
                                (exercise.correct_vocabulary.length * 3) / 3
                            )
                        "
                        @click="provideHintThird"
                    >
                        <img
                            src="../../../images/exercises/help3.png"
                            alt="Aide 3/3"
                            width="35px"
                        />
                    </button>
                </section>
            </div>
        </div>

        <div
            v-if="feedbackMessage !== null"
            class="d-flex-center"
            style="margin-top: 25px"
        >
            <next-exercise
                class="d-flex-center"
                :exercise="exercise"
                :nextExercise="nextExercise"
                :feedbackMessage="feedbackMessage"
            ></next-exercise>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import ContainerHead from "./partials/first_vocabulary/ContainerHead.vue";
import CheckedFail from "./partials/second_vocabulary/CheckedFail.vue";
import NextExercise from "./partials/second_vocabulary/NextExercise.vue";

export default {
    name: "SecondVocabulary",
    components: { ContainerHead, CheckedFail, NextExercise },
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
                this.handleKeydown(event);
            },
        },
        userAnswer(newVal) {
            if (newVal.length === this.exercise.correct_vocabulary.length) {
                this.validateAnswer();
            }
        },
    },
    computed: {
        placeholderText() {
            return "_ ".repeat(this.currentExercise.correct_vocabulary.length);
        },
    },
    methods: {
        handleKeydown(event) {
            if (this.feedbackMessage && event.key !== " ") {
                event.preventDefault(); // on blocque l'événement clavier pour que l'user puisse pas modifier sa réponse si juste
            }

            if (event.key === " ") {
                event.preventDefault();

                if (this.currentExercise !== null) {
                    this.determineNextExercise();

                    if (
                        this.userAnswer.trim().toLowerCase() != null &&
                        this.userAnswer.trim().toLowerCase() ==
                            this.currentExercise.correct_vocabulary.toLowerCase()
                    ) {
                        this.userAnswer = "";

                        this.$router.push({
                            name: "exercise",
                            params: {
                                id: 1,
                                level_id: 1,
                                exercise_id: this.nextExercise,
                            },
                        });
                    } else {
                        this.userAnswer = "";
                    }
                }
            }
        },
        determineNextExercise() {
            let id = this.$route.params.exercise_id;

            axios.get(`/get-next-exercise-by-order/${id}`).then((response) => {
                this.nextExercise = response.data.id;
                this.userAnswer = "";
            });

            return this.nextExercise;
        },
        checkAnswer(event) {
            this.userAnswer = event.target.value;
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

<style scoped lang="scss">
.answer {
    text-align: center;
    padding-top: 25px;

    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    width: 796px;
    height: 50px;
    border-radius: 10px;
    border: solid 2px #f8da61;

    font-size: 22px;
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

button {
    background-color: transparent;
    border: none;

    img {
        cursor: pointer;
    }
}
#section-sentenceParts {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: -25px;
}
#section-counterLetters {
    display: flex;
    justify-content: right;
    margin-top: -86.5px;
    padding-right: 275px;
}
#sous-section-counterLetters {
    background-color: #ae7cf6;
    border-radius: 10px;
    padding: 0px;
    padding-left: 20px;
    padding-right: 20px;
    color: white;
}
#section-checkedFail {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 47.5px;
}
</style>
