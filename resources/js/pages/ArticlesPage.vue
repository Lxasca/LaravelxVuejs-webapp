<template>
    <div id="articles-page">
        <!-- les filtres -->
        <div
            style="
                margin-left: 2.5%;
                margin-right: 3.5%;
                display: flex;
                justify-content: space-between;
            "
        >
            <article-filter @update:filters="updateFilters"></article-filter>
        </div>

        <get-articles
            :articles="articles"
            :articlesEmpty="articlesEmpty"
        ></get-articles>
    </div>
</template>

<script>
import axios from "axios";
import GetArticles from "../components/article/GetArticles.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "../../../src/components/ui/select";

import ArticleFilter from "@/components/filters/ArticleFilter.vue";

export default {
    name: "ArticlesPage",
    components: {
        GetArticles,
        Select,
        SelectContent,
        SelectGroup,
        SelectItem,
        SelectLabel,
        SelectTrigger,
        SelectValue,
        ArticleFilter,
    },
    data() {
        return {
            articles: [],
            sortOrder: "desc",
            selectedLevelName: null,
            selectedCategoryName: null,
            articlesEmpty: "",
        };
    },
    watch: {
        // lorsque sortOrder change, on relance le tri
        sortOrder() {
            this.getArticles();
        },
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        getArticles() {
            axios.get(`/get-articles`).then((response) => {
                this.articles = Array.isArray(response.data)
                    ? response.data.map((article) => ({
                          ...article,
                          isSwitched: false,
                      }))
                    : [];
                this.sortArticles();
            });
        },
        sortArticles() {
            this.articles = this.articles
                .filter((article) => {
                    const matchesLevel =
                        !this.selectedLevelName ||
                        article.level.name === this.selectedLevelName;
                    const matchesCategory =
                        !this.selectedCategoryName ||
                        article.category.name === this.selectedCategoryName;
                    return matchesLevel && matchesCategory;
                })
                .sort((a, b) => {
                    const dateA = new Date(a.created_at);
                    const dateB = new Date(b.created_at);

                    return this.sortOrder === "asc"
                        ? dateA - dateB
                        : dateB - dateA;
                });

            if (this.articles.length == 0) {
                this.articlesEmpty =
                    "Oup's, aucun article ne correspond à votre recherche.";
            } else {
                this.articlesEmpty = "";
            }
        },
        updateFilters(filters) {
            this.selectedLevelName = filters.level;
            this.selectedCategoryName = filters.category;
            this.sortOrder = filters.sortOrder;

            this.getArticles();
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

<style scoped>
@media (min-width: 767px) {
    #articles-page {
        padding-left: 50px;
        padding-right: 50px;
    }
}
</style>
