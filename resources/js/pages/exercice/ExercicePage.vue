<template>
    <div>
        <h1>exercice page</h1>

        <ul>
            <li v-for="vocab in vocabularies" :key="vocab.id">
                <h5>{{ vocab.traduction_arabic }}</h5>
                <p>{{ vocab.transcription_arabic }}</p>
                <button
                    v-for="(word, i) in getShuffledWords(vocab.word, index)"
                    :key="i"
                    @click="checkAnswer(word, vocab.word, vocab.id)"
                >
                    {{ word }}
                </button>

                <p v-if="vocab.feedback">{{ vocab.feedback }}</p> 
            </li>
        </ul>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ExercicePage",
    data() {
        return {
            vocabularies: [],
            article: {},
        };
    },
    mounted() {
        this.getVocabularies();
    },
    methods: {
        checkAnswer(selectedWord, correctWord, vocabId) {
            const vocab = this.vocabularies.find(v => v.id === vocabId);
            if (!vocab) return;

            vocab.feedback = selectedWord === correctWord ? "Succès" : "Erreur";
        },
        getVocabularies() {
            // on récupère tous les mots de vocabulaires de l'article :

            const articleId = this.$route.params.article_id;

            axios.get(`/get-article/${articleId}`).then((response) => {
                this.article = response.data;

                const extractTagIds = (text) => {
                    const matches = [...text.matchAll(/\S+<(\d+)>/g)];
                    return matches.map((match) => match[1]);
                };

                const tagIds = [
                    ...extractTagIds(response.data.content || ""),
                    ...extractTagIds(response.data.content_2 || ""),
                ];

                const uniqueIds = [...new Set(tagIds)];

                this.vocabularies = [];

                uniqueIds.forEach((id) => {
                    axios.get(`/get-vocabulary/${id}`).then((res) => {
                        const v = res.data;
                        this.vocabularies.push({
                            id: v.id || Number(id),
                            word_opposite_1: v.word_opposite_1,
                            image: v.image,
                            audio_arabic: v.audio_arabic,
                            traduction_arabic: v.traduction_arabic,
                            transcription_arabic: v.transcription_arabic,
                            word: v.word,
                            feedback: null // ajout pour la vue
                        });
                    });
                });
            });
        },
        getRandomOtherWord(currentWord) {
            const others = this.vocabularies.filter(
                (v) => v.word !== currentWord
            );
            if (others.length === 0) return null;
            const randomIndex = Math.floor(Math.random() * others.length);
            return others[randomIndex].word;
        },
        getShuffledWords(correctWord, currentIndex) {
            const otherWord = this.getRandomOtherWord(correctWord);
            if (!otherWord) return [correctWord];

            const pair = [correctWord, otherWord];
            // on mélange le tableau
            for (let i = pair.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [pair[i], pair[j]] = [pair[j], pair[i]];
            }
            return pair;
        },
    },
};
</script>

<style scoped>

button {
    border:solid 1px black;
    border-radius: 15px;
    padding: 5px 20px;
    margin: 0px 7.5px;
}</style>
