<template>
    <div>
        <h1>exercice page</h1>

        <div v-if="currentVocab">
            <h5>{{ currentVocab.traduction_arabic }}</h5>
            <p>{{ currentVocab.transcription_arabic }}</p>

            <div v-if="currentVocab.feedback !== 1">
                <button
                    v-for="(word, i) in getShuffledWords(currentVocab.word, currentIndex)"
                    :key="i"
                    :disabled="currentVocab.feedback === 1"
                    @click="checkAnswer(word, currentVocab.word, currentVocab.id)"
                    >
                    {{ word }}
                </button>
            </div>

            <p v-if="currentVocab.feedback === 1">Succès</p>
            <p v-else-if="currentVocab.feedback === 0">Erreur</p>

            <button
                v-if="currentVocab.feedback === 1"
                style="background-color: #262626;color:#fbfbfb"
                @click="nextVocab"
            >
                Suivant
            </button>
        </div>

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
            currentIndex: 0,
        };
    },
    mounted() {
        this.getVocabularies();
    },
    computed: {
        currentVocab() {
            return this.vocabularies[this.currentIndex] || null;
        }
    },
    methods: {
        checkAnswer(selectedWord, correctWord, vocabId) {
            const vocab = this.vocabularies.find(v => v.id === vocabId);
            if (!vocab) return;

            vocab.feedback = selectedWord === correctWord ? 1 : 0;
        },
        nextVocab() {
            this.currentVocab.feedback = null;


            if (this.currentIndex < this.vocabularies.length - 1) {
                this.currentIndex++;
            }
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
