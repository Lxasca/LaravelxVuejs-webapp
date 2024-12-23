<template>
    <div>
        <p>
            <span v-for="(part, index) in sentenceParts" :key="index">
                <span v-if="part.isWord">
                    <input
                        type="text"
                        v-model="part.value"
                        class="word-input"
                        :placeholder="part.original"
                    />
                </span>
                <span v-else>{{ part.text }}</span>
            </span>
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
            sentenceParts: [],
        };
    },
    mounted() {
        this.getVocabulariesOfSentence();
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

                console.log("arrayWords : ", this.arrayWords);

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
    },
};
</script>

<style scoped></style>
