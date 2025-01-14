<template>
    <div
        style="
            padding-left: 150px;
            padding-right: 150px;
            padding-top: 0px;
            padding-bottom: 0px;
        "
    >
        <section class="div-content">
            <div>
                <section id="div-content-section">
                    <section style="text-align: left; font-size: 20px">
                        <button id="button-createdAt">
                            {{
                                new Date(article.created_at).toLocaleDateString(
                                    "fr-FR"
                                )
                            }}
                        </button>
                    </section>

                    <h5>
                        <span v-if="!isSwitched">{{ article.title }}</span>
                        <span id="title-french" v-else>
                            {{ article.title_french }}
                        </span>

                        <img
                            @click="changeLanguage()"
                            src="../../images/exercises/translate.png"
                            width="20px"
                            alt=""
                        />
                    </h5>
                </section>
                <p v-if="!isSwitched">
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
                <p v-else id="content-french">{{ article.content_french }}</p>
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
            isSwitched: false,
        };
    },
    mounted() {
        this.getArticle();
    },
    methods: {
        changeLanguage() {
            this.isSwitched = !this.isSwitched;
        },
        getArticle() {
            const id = this.$route.params.article_id;

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

<style scoped>
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

    text-align: right;
    padding: 25px;
    border-radius: 12.5px;
}

.div-translation {
    text-align: center;
    font-size: 25px;
    width: 76%;

    position: fixed;
    top: 12.5%;
    left: 50%;
    transform: translate(-50%, -50%);

    background-color: white;

    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    border-radius: 12.5px;
}
#div-content-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);

    border-radius: 12.5px;
    padding-left: 25px;
    padding-right: 25px;
    height: 85px;

    margin-bottom: 45px;
}
#button-createdAt {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 12.5px;
    background-color: #262626;
    color: #fbfbfb;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    letter-spacing: 1px;
}
img {
    margin-left: 15px;
    transform: rotate(180deg);
    cursor: pointer;
}
h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 30px;
}
#title-french {
    font-size: 22.5px;
}
#content-french {
    font-size: 30px;
    text-align: left;
}
</style>
