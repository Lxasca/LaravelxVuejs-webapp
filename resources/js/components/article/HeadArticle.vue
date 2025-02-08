<template>
    <div id="head-article">
        <section>
            <button class="button-createdAt btn-0">
                {{ new Date(article.created_at).toLocaleDateString("fr-FR") }}
            </button>
        </section>

        <section>
            <h5>
                <span>{{ article.title }}</span>

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
    props: {
        article: {
            type: Object,
        },
    },
};
</script>
<style scoped>
#head-article {
    display: flex;
    justify-content: space-between;
    align-items: center;

    font-size: 20px;

    background-color: #fbfbfb;
    margin-bottom: 35px;

    height: 80px;

    padding: 28px;
    padding-top: 5px;
    padding-bottom: 5px;
    border-radius: 7.5px;
}

/** responsive **/
@media (max-width: 767px) {
    #head-article {
        height: 80px;
        display: block;
    }
    h5 {
        font-size: 25px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.2;
        text-align: right;
        direction: rtl;

        margin-top: -50px;
    }
    .btn-0 {
        margin-left: -15px;
    }
}
</style>
