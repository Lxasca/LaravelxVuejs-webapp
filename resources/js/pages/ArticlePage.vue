<template>
    <div>
        <section class="div-content">
            <div>
                <section style="display: flex; justify-content: space-between">
                    <h5>
                        {{
                            new Date(article.created_at).toLocaleDateString(
                                "fr-FR"
                            )
                        }}
                    </h5>

                    <h5 style="font-weight: bold">
                        {{ article.title }}

                        <img
                            src="../../images/exercises/change.png"
                            width="30px"
                            alt=""
                        />
                    </h5>
                </section>
                <p>
                    <span
                        v-for="(match, index) in getMatches(article.content)"
                        :key="index"
                    >
                        <span
                            v-if="match.type === 'number'"
                            class="clickable-number"
                            @click="handleClick(match.id)"
                        >
                            {{ match.text }}
                        </span>

                        <span v-else>{{ match.text }}</span>
                    </span>
                </p>
            </div>
        </section>

        <section class="div-translation" v-if="showTranslation">
            <button @click="close">x</button>
            <p>
                <span style="color: green">{{ traductionArabic }}</span>
                [<span style="color: orange">{{ transcriptionArabic }}</span
                >] se traduit par
                <span style="color: blue">{{ traductionFrancais }}</span
                >.
            </p>
        </section>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ArticlePage",
    data() {
        return {
            article: {},
            showTranslation: false,
            traductionArabic: "",
            traductionFrancais: "",
            transcriptionArabic: "",
            currentId: null,
        };
    },
    mounted() {
        this.getArticle();
    },
    methods: {
        getArticle() {
            const id = this.$route.params.article_id;

            console.log("yoo ", id);

            axios
                .get(`/get-article/${id}`)
                .then((response) => {
                    this.article = response.data;
                })
                .catch((error) => {
                    console.log("erreur : ", error);
                });
        },
        getMatches(content) {
            if (!content) return [];

            const regex = /\[(\d+)\]/g;
            let match;
            const matches = [];
            let lastIndex = 0;

            while ((match = regex.exec(content)) !== null) {
                if (match.index > lastIndex) {
                    matches.push({
                        text: content.slice(lastIndex, match.index),
                    });
                }
                matches.push({ text: match[1], type: "number", id: match[1] });

                lastIndex = regex.lastIndex;
            }

            if (lastIndex < content.length) {
                matches.push({ text: content.slice(lastIndex) });
            }

            return matches;
        },
        handleClick(id) {
            if (this.currentId === id && this.showTranslation) {
                this.showTranslation = false;
                return;
            }

            axios.get(`/get-vocabulary/${id}`).then((response) => {
                this.traductionArabic = response.data.traduction_arabic;
                this.traductionFrancais =
                    response.data.word.charAt(0).toLowerCase() +
                    response.data.word.slice(1);
                this.transcriptionArabic = response.data.transcription_arabic;
                this.currentId = id;
                this.showTranslation = true;
            });
        },
        close() {
            this.showTranslation = false;
        },
    },
};
</script>

<style>
.clickable-number {
    cursor: pointer;
    color: green;
    letter-spacing: normal;

    position: relative;
    top: -20px;
    right: -5px;
    font-size: 15px;
}

.div-content {
    font-size: 45px;
    line-height: 80px;

    padding-left: 250px;
    padding-right: 250px;

    text-align: right;
}

.div-translation {
    text-align: center;
    font-size: 25px;
    width: 65%;

    position: fixed;
    top: 15%;
    left: 50%;
    transform: translate(-50%, -50%);

    background-color: white;

    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    border-radius: 12.5px;
}
</style>
