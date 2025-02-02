<template>
    <div>
        <section class="div-content">
            <div v-for="article in articles" :key="article.id">
                <section id="div-content-section">
                    <button
                        class="button-createdAt btn-0"
                        style="margin-top: 5px"
                    >
                        {{
                            new Date(article.created_at).toLocaleDateString(
                                "fr-FR"
                            )
                        }}
                    </button>

                    <h5>
                        <router-link
                            :to="{
                                name: 'article',
                                params: { article_id: article.id },
                            }"
                            style="text-decoration: none; color: black"
                        >
                            <span v-if="!article.isSwitched">{{
                                article.title
                            }}</span>
                            <span id="title-french" v-else>
                                {{ article.title_french }}
                            </span>
                        </router-link>
                    </h5>
                </section>
            </div>
        </section>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ArticlesPage",
    data() {
        return {
            articles: [],
        };
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
    mounted() {
        this.getArticles();
    },
};
</script>

<style scoped>
.div-content {
    font-size: 45px;
    line-height: 80px;

    text-align: center;
    padding-left: 2.5%;
    padding-right: 3.5%;
}
#div-content-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fbfbfb;

    border-radius: 7.5px;
    padding: 28px;
    padding-top: 5px;
    padding-bottom: 5px;

    height: 80px;

    margin-bottom: 25px;
}

h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 30px;
}
</style>
