<template>
    <div id="head-article">
        <section>
            <button class="button-createdAt btn-0">
                {{ new Date(article.created_at).toLocaleDateString("fr-FR") }}
            </button>
        </section>

        <section>
            <h5>
                <span v-if="!isSwitched">{{ article.title }}</span>
                <span id="title-french" v-else>
                    {{ article.title_french }}
                </span>

                <!--<img
                    @click="changeLanguage()"
                    src="../../../images/exercises/translate.png"
                    width="20px"
                    alt=""
                />-->
            </h5>
        </section>
    </div>
</template>

<script>
export default {
    name: "HeadArticle",
    data() {
        return {
            isSwitched: false,
        };
    },
    props: {
        article: {
            type: Object,
        },
    },
    methods: {
        changeLanguage() {
            this.isSwitched = !this.isSwitched;
        },
    },
};
</script>
<style scoped>
.btn-0 {
    background-color: #262626;
    color: #fbfbfb;
    border: none;
}
#title-french {
    font-size: 22.5px;
}
#head-article {
    display: flex;
    justify-content: space-between;
    align-items: center;

    font-size: 20px;

    background-color: #fbfbfb;
    height: 80px;
    margin-bottom: 35px;

    padding: 28px;
    padding-top: 5px;
    padding-bottom: 5px;
    border-radius: 7.5px;
}
</style>
