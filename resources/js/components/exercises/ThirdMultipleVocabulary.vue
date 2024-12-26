<template>
    <div>
        <!-- affichage des images -->
        <section>
            <div v-for="arrayImage in arrayImages" :key="arrayImage.id">
                <img
                    :src="arrayImage"
                    alt="Image d'illustration"
                    width="150px"
                />
            </div>
        </section>

        <p>
            <span v-for="(part, index) in sentenceParts" :key="index">
                <span v-if="part.isWord">
                    <input
                        type="text"
                        v-model="part.value"
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
                        exercise_id: nextExerciseId,
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
export default {
    name: "ThirdMultiple",
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
        };
    },
    mounted() {
        this.getVocabulariesOfSentence();
    },
    computed: {
        nextExerciseId() {
            return parseInt(this.$route.params.exercise_id) + 1;
        },
    },
    methods: {
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
            let isValid = true;
            this.sentenceParts.forEach((part) => {
                if (
                    part.isWord &&
                    part.value.toLowerCase() !== part.original.toLowerCase()
                ) {
                    isValid = false;
                }
            });

            this.resultMessage = isValid ? "Réussi !" : "Raté !";
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
