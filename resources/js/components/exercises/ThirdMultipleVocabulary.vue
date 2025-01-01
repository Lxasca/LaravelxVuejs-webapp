<template>
    <div>
        <!-- 1. Affichage du header de l'exercice : images et vocabulaires -->
        <container-head
            :exercise="exercise"
            :arrayImages="arrayImages"
            :arrayTraductions="arrayTraductions"
        ></container-head>

        <div class="d-flex-center">
            <p class="answer">
                <span v-for="(part, index) in sentenceParts" :key="index">
                    <span v-if="part.isWord">
                        <input
                            type="text"
                            v-model="part.value"
                            :placeholder="placeholderText(part.original)"
                            class="word-input"
                            :class="{
                                'border-red-500':
                                    part.value &&
                                    part.value.toLowerCase() !==
                                        part.original.toLowerCase(),
                            }"
                        />
                        <!--:placeholder="part.original"-->
                    </span>
                    <span v-else>{{ part.text }}</span>
                </span>
            </p>
        </div>

        <button @click="validateAnswers">Valider</button>
        <p
            v-if="resultMessage"
            :class="{
                'text-green-500': resultMessage === 'Réussi !',
                'text-red-500': resultMessage === 'Raté !',
            }"
        >
            {{ resultMessage }}

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
                Suivant
            </router-link>
        </p>
    </div>
</template>

<script>
import axios from "axios";
import ContainerHead from "./partials/third_vocabulary/ContainerHead.vue";
export default {
    name: "ThirdMultiple",
    components: { ContainerHead },
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            arrayWords: [],
            arrayImages: [],
            sentenceParts: [],
            resultMessage: "",
            nextExercise: null,
            isValid: false,
            arrayTraductions: [],
        };
    },
    computed: {
        placeholderText() {
            return (val) => (val ? "_ ".repeat(val.length).trim() : "");
        },
    },
    mounted() {
        this.getVocabulariesOfSentence();
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
                this.determineNextExercise();
            },
        },
    },
    methods: {
        handleKeydown(event) {
            if (
                event.code === "Space" &&
                document.activeElement.tagName !== "INPUT"
            ) {
                this.validateAnswers();

                if (this.isValid === true) {
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
        },
        determineNextExercise() {
            let id = this.$route.params.exercise_id;

            axios.get(`/get-next-exercise-by-order/${id}`).then((response) => {
                this.nextExercise = response.data.id;
            });
        },
        async getVocabulariesOfSentence() {
            try {
                const vocabularies = JSON.parse(this.exercise.vocabularies);

                const promises = vocabularies.map((id) =>
                    axios.get(`/get-vocabulary/${id}`)
                );

                const responses = await Promise.all(promises);

                this.arrayWords = responses.map(
                    (response) => response.data.word
                );

                this.arrayImages = responses.map(
                    (response) => response.data.image
                );

                this.arrayTraductions = responses.map(
                    (response) => response.data.traduction_arabic
                );

                this.detectWordsInSentence();
            } catch (error) {
                console.error("Erreur lors de la récupération des mots", error);
            }
        },

        detectWordsInSentence() {
            const lowerSentence = this.exercise.sentence.toLowerCase();
            const words = [...this.arrayWords].map((word) =>
                word.toLowerCase()
            );
            const regex = new RegExp(`\\b(${words.join("|")})\\b`, "gi");

            const matches = [];
            let lastIndex = 0;

            lowerSentence.replace(regex, (match, p1, offset) => {
                if (offset > lastIndex) {
                    matches.push({
                        text: this.exercise.sentence.slice(lastIndex, offset),
                        isWord: false,
                    });
                }
                matches.push({
                    original: p1,
                    value: "",
                    isWord: true,
                });
                lastIndex = offset + p1.length;
            });

            if (lastIndex < this.exercise.sentence.length) {
                matches.push({
                    text: this.exercise.sentence.slice(lastIndex),
                    isWord: false,
                });
            }

            this.sentenceParts = matches;
        },

        validateAnswers() {
            this.isValid = true;
            this.sentenceParts.forEach((part) => {
                if (
                    part.isWord &&
                    part.value.toLowerCase() !== part.original.toLowerCase()
                ) {
                    this.isValid = false;
                }
            });

            this.resultMessage = this.isValid ? "Réussi !" : "Raté !";
        },
    },
};
</script>

<style scoped>
.word-input {
    border: 1px solid #ccc;
    padding: 5px;
    width: 100px;
}

.text-green-500 {
    color: green;
}

.text-red-500 {
    color: red;
}

.border-green-500 {
    border-color: green;
}

.border-red-500 {
    border-color: red;
}
</style>
