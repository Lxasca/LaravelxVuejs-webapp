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
                    />
                </span>
            </p>
            <p>
                <button v-if="userAnswer.length > 0" @click="validateAnswer">
                    Valider
                </button>
                <button
                    v-if="userAnswer.length < 1 || !feedbackMessage"
                    @click="provideHint"
                >
                    Aide
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
                            exercise_id: nextExerciseId,
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
        };
    },
    mounted() {
        this.resetState();
        this.updateSentenceParts();
    },
    watch: {
        "$route.params.exercise_id": {
            immediate: true,
            handler() {
                this.resetState();
                this.updateSentenceParts();
            },
        },
    },
    computed: {
        nextExerciseId() {
            return parseInt(this.$route.params.exercise_id) + 1;
        },
        placeholderText() {
            return "_ ".repeat(this.currentExercise.correct_vocabulary.length);
        },
    },
    methods: {
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
        provideHint() {
            this.userAnswer = this.currentExercise.correct_vocabulary.charAt(0);
        },
        resetState() {
            this.feedbackMessage = null;
            this.userAnswer = "";
        },
        updateSentenceParts() {
            const exercise_id = parseInt(this.$route.params.exercise_id);

            axios
                .get(`/get-exercise/${exercise_id}`)
                .then((response) => {
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
                })
                .catch((error) => {
                    console.log("fuck ", error);
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
