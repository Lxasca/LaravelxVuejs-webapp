<template>
    <div>
        <h3>Exercice texte à trou</h3>
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
            <button @click="validateAnswer">Valider</button>
            <button @click="provideHint">Aide</button>
        </p>

        <div v-if="feedbackMessage">
            <p>{{ feedbackMessage }}</p>

            <router-link
                :to="{
                    name: 'exercise',
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: exercise.id + 1,
                    },
                }"
            >
                Suivant (passer)
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "SecondVocabulary",
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
            userAnswer: "",
            feedbackMessage: "",
        };
    },
    computed: {
        sentenceParts() {
            const wordToReplace = this.exercise.correct_vocabulary;
            const parts = this.exercise.sentence.split(wordToReplace);
            return parts.flatMap((part, index) => [
                { text: part, isInput: false },
                ...(index < parts.length - 1
                    ? [{ text: "", isInput: true }]
                    : []),
            ]);
        },
        placeholderText() {
            return "_ ".repeat(this.exercise.correct_vocabulary.length);
        },
    },
    methods: {
        validateAnswer() {
            if (
                this.userAnswer.trim().toLowerCase() ===
                this.exercise.correct_vocabulary.toLowerCase()
            ) {
                this.feedbackMessage = "Bonne réponse !";
            } else {
                this.feedbackMessage = "Mauvaise réponse, essayez encore.";
            }
        },
        provideHint() {
            this.userAnswer = this.exercise.correct_vocabulary.charAt(0);
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
</style>
