<template>
    <get-articles :articles="articles"></get-articles>
</template>

<script>
import axios from "axios";
import GetArticles from "../components/article/GetArticles.vue";

export default {
    name: "ArticlesPage",
    components: { GetArticles },
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
                this.articles = response.data.map((article) => ({
                    ...article,
                    isSwitched: false,
                }));
            });
        },
        changeLanguage(articleId) {
            this.articles = this.articles.map((article) => {
                if (article.id === articleId) {
                    article.isSwitched = !article.isSwitched;
                }
                return article;
            });
        },
    },
};
</script>
