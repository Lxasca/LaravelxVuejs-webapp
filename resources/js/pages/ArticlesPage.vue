<template>
    <div>
        <h1>Articles pages</h1>

        <section>
            <div v-for="article in articles" :key="article.id">
                <p>
                    <span
                        v-for="(segment, index) in splitContent(
                            article.content
                        )"
                        :key="index"
                    >
                        <!-- Si le segment est un lien / mot de Vocabularies ... -->
                        <router-link
                            v-if="segment.isLink"
                            :to="{
                                name: 'course',
                                params: { id: segment.number },
                            }"
                            class="text-blue-500 underline"
                        >
                            {{ segment.word }}[{{ segment.number }}]
                        </router-link>

                        <span v-else>{{ segment.text }}</span>
                    </span>
                </p>
            </div>
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
                    number: parseInt(match[2]),
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
    },
};
</script>

<style scoped></style>
