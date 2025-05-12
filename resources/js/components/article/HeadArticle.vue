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

h5 {
    font-size: 45px;
}

@media (max-width: 767px) {
    #head-article {
        padding-right: 20px;
        padding-left: 5px;
    }
    h5 {
        font-size: 45px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.5;
        text-align: center;
    }
    .btn-0 {
        margin-left: -15px;
    }
}
</style>
