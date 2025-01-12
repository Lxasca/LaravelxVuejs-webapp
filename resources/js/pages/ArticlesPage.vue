<template>
    <div>
        <h1>Articles pages</h1>

        <section class="div-content">
            <div v-for="article in articles" :key="article.id">
                <p>
                    <span
                        v-for="(segment, index) in splitContent(
                            article.content
                        )"
                        :key="index"
                    >
                        <span v-if="segment.isLink">
                            {{ segment.word }}
                            <span
                                @click="toggleVocabulary(segment.number)"
                                class="segment-number"
                            >
                                {{ segment.number }}
                            </span>
                        </span>
                        <span v-else>{{ segment.text }}</span>
                    </span>
                </p>
            </div>
        </section>

        <section class="div-currentWord" v-if="currentWord">
            <p>{{ currentWord }}</p>
            <br />
            <p>{{ traductionArabic }}</p>
        </section>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ArticlesPages",
    data() {
        return {
            articles: [],
            currentWord: "",
            traductionArabic: "",
            currentId: null,
        };
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        getArticles() {
            axios.get("/get-articles").then((response) => {
                this.articles = response.data;
            });
        },
        splitContent(content) {
            const regex = /(\w+)\[(\d+)\]/g;
            let segments = [];
            let lastIndex = 0;
            let match;

            while ((match = regex.exec(content)) !== null) {
                if (match.index > lastIndex) {
                    segments.push({
                        text: content.slice(lastIndex, match.index),
                        isLink: false,
                    });
                }
                segments.push({
                    word: match[1],
                    number: match[2],
                    isLink: true,
                });
                lastIndex = regex.lastIndex;
            }

            if (lastIndex < content.length) {
                segments.push({
                    text: content.slice(lastIndex),
                    isLink: false,
                });
            }

            return segments;
        },
        toggleVocabulary(id) {
            if (this.currentId === id) {
                this.currentWord = "";
                this.currentId = null;
            } else {
                axios.get(`/get-vocabulary/${id}`).then((response) => {
                    this.currentWord = response.data.word;
                    this.traductionArabic = response.data.traduction_arabic;
                    this.currentId = id;
                });
            }
        },
    },
};
</script>

<style scoped>
.segment-number {
    color: blue;
    cursor: pointer;
    font-size: 12px;
    font-weight: bold;

    position: relative;
    top: -0.5em;
}

.div-currentWord {
    padding: 50px;
    background-color: #fbfbfb;
}
</style>
