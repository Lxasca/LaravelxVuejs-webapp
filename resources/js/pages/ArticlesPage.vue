<template>
    <div id="articles-page">
        <!-- les filtres -->
        <div style="margin-left: 2.5%">
            <section>
                <Select v-model="sortOrder">
                    <SelectTrigger style="width: 225px">
                        <SelectValue placeholder="Trier par date" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="asc">
                                Du plus ancien au plus récent
                            </SelectItem>
                            <SelectItem value="desc">
                                Du plus récent au plus ancien
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </section>
        </div>

        <get-articles :articles="articles"></get-articles>
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
    },
    data() {
        return {
            articles: [],
            sortOrder: "desc",
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
            axios.get("/get-articles").then((response) => {
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
            this.articles.sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);

                if (this.sortOrder === "asc") {
                    return dateA - dateB; // du plus ancien au plus récent
                } else {
                    return dateB - dateA; // du plus récent au plus ancien
                }
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

<style scoped>
#articles-page {
    padding-left: 50px;
    padding-right: 50px;
}
</style>
