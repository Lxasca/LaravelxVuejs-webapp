<template>
    <div>
        <h1>Articles Pages</h1>

        <section class="div-content">
            <div v-for="article in articles" :key="article.id">
                <section id="div-content-section">
                    <section style="text-align: left; font-size: 20px">
                        <button id="button-createdAt">
                            {{
                                new Date(article.created_at).toLocaleDateString(
                                    "fr-FR"
                                )
                            }}
                        </button>
                    </section>

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

                        <img
                            src="../../images/exercises/translate.png"
                            @click="changeLanguage(article.id)"
                            width="20px"
                            alt=""
                        />
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
    padding-left: 150px;
    padding-right: 150px;
}
#div-content-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);

    border-radius: 7.5px;
    padding-left: 25px;
    padding-right: 25px;
    height: 85px;

    margin-bottom: 45px;
}
#button-createdAt {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 7.5px;
    background-color: #262626;
    color: #fbfbfb;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
    letter-spacing: 1px;
}
h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 30px;
}
#title-french {
    font-size: 22.5px;
}
img {
    margin-left: 15px;
    transform: rotate(180deg);
    cursor: pointer;
}
#title-french {
    font-size: 22.5px;
}
</style>
