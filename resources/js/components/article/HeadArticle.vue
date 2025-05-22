<template>
    <div id="head-article">
        <section class="direction-text-right">
            <h5>
                <span>{{ article.title }}</span>
            </h5>
        </section>

        <section>
            <h6>
                <span>{{ article.title_french }}</span>
            </h6>
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
    margin-left: 25px;
    margin-right: 25px;
}

h5 {
    font-size: 42.5px;
}
h6 {
    font-size: 28px;
}

@media (max-width: 767px) {
    #head-article {
        margin-left: 25px;
        margin-right: 35px;
    }
    h5 {
        font-size: 35px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.5;
        text-align: center;
    }
    h6 {
        font-size: 20px;
    }
    .btn-0 {
        margin-left: -15px;
    }
}
</style>
