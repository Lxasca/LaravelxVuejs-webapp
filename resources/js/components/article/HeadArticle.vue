<template>
    <div id="head-article" class="direction-text-right">
        <section>
            <h5>
                <span>{{ article.title }}</span>
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
    padding-right: 28px;
    padding-bottom: 10px;
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
