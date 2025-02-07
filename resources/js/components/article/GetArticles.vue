<template>
    <div class="div-content">
        <div v-for="article in articles" :key="article.id">
            <section id="div-content-section">
                <button class="button-createdAt btn-0" style="margin-top: 5px">
                    {{
                        new Date(article.created_at).toLocaleDateString("fr-FR")
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

                <!-- si is Admin -->
                <div v-if="isAdmin" style="margin-top: -10px">
                    <button
                        @click="formEdit(article)"
                        class="button-createdAt btn-0"
                    >
                        Editer
                    </button>
                    <button
                        class="button-createdAt btn-0"
                        style="margin-left: 10px"
                    >
                        Supprimer
                    </button>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    name: "GetArticles",
    props: {
        articles: {
            type: Object,
        },
        isAdmin: {
            type: Boolean,
            required: false,
        },
    },
    methods: {
        formEdit(article) {
            this.$emit("is-form-edit", article);
        },
    },
};
</script>

<style scoped>
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

.div-content {
    font-size: 45px;
    line-height: 80px;

    text-align: center;
    padding-left: 2.5%;
    padding-right: 3.5%;
}

h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 30px;
}
</style>
