<template>
    <div>
        <h1>Articles Pages</h1>

        <section class="div-content">
            <div v-for="(article, articleIndex) in articles" :key="article.id">
                <section
                    style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05),
                            0 1px 2px rgba(0, 0, 0, 0.03);

                        border-radius: 12.5px;
                        padding-left: 50px;
                        padding-right: 50px;
                        height: 115px;

                        margin-bottom: 35px;
                    "
                >
                    <section style="text-align: left; font-size: 20px">
                        <button
                            style="
                                padding-top: 10px;
                                padding-bottom: 10px;
                                padding-left: 25px;
                                padding-right: 25px;
                                border-radius: 12.5px;
                                background-color: #262626;
                                color: #fbfbfb;
                                letter-spacing: 1px;
                            "
                        >
                            {{
                                new Date(article.created_at).toLocaleDateString(
                                    "fr-FR"
                                )
                            }}
                        </button>
                    </section>

                    <h5
                        style="
                            font-weight: bold;
                            display: flex;
                            align-items: center;
                            padding: 0;
                        "
                    >
                        <span v-if="!article.isSwitched">{{
                            article.title
                        }}</span>
                        <span style="font-size: 25px" v-else>
                            {{ article.title_french }}
                        </span>

                        <img
                            @click="changeLanguage(article.id)"
                            style="
                                margin-left: 15px;
                                transform: rotate(180deg);
                                cursor: pointer;
                            "
                            src="../../images/exercises/change.png"
                            width="30px"
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

<style>
.div-content {
    font-size: 45px;
    line-height: 80px;

    padding-left: 250px;
    padding-right: 250px;

    text-align: right;
}
</style>
