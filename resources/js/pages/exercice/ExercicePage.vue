<template>
    <div>
        <h1>exercice page</h1>
        <p>Les mots</p>
        <ul>
            <li v-for="vocab in vocabularies" :key="vocab.id">
                <h5>{{ vocab.traduction_arabic }}</h5>
                <Button> {{ vocab.word }}</Button>
                <Button> {{ getRandomOtherWord(index) }}</Button>
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
                            word_opposite_1: v.word_opposite_1,
                            image: v.image,
                            audio_arabic: v.audio_arabic,
                            traduction_arabic: v.traduction_arabic,
                            transcription_arabic: v.transcription_arabic,
                            word: v.word,
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
    },
};
</script>

<style scoped></style>
