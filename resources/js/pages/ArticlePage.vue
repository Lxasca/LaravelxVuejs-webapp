<template>
    <div id="article-page">
        <section
            :style="{
                fontSize: fontSize + 'px',
                lineHeight: fontSize * 2.2 + 'px',
            }"
        >
            <div>
                <!-- La date à gauche, le titre et sa traduction à droite -->
                <head-article :article="article"></head-article>

                <!-- les actions possibles sur le contenu de l'article -->
                <actions-article
                    :isShowHelp="isShowHelp"
                    :dropdownIsShow="dropdownIsShow"
                    :buttonConfig="buttonConfig"
                    v-model:fontSize="fontSize"
                ></actions-article>

                <!-- article -->
                <section class="section-article">
                    <div v-for="i in numberOfContent" :key="i">
                        <p class="direction-text-right">
                            <span
                                :style="{ unicodeBidi: 'plaintext' }"
                                v-for="(match, index) in getMatches(
                                    getContentByIndex(i)
                                )"
                                :key="index"
                            >
                                <span
                                    v-if="match.type === 'number'"
                                    class="clickable-number"
                                    @click="handleClick(match.id)"
                                >
                                    <img
                                        src="../../images/exercises/interrogation.png"
                                        width="30px"
                                        class="rotate-0"
                                        v-if="isShowHelp"
                                    />
                                </span>

                                <span v-else>
                                    <span
                                        v-html="highlightWords(match.text)"
                                    ></span>
                                </span>
                            </span>
                        </p>

                        <p v-if="isSwitchedContent" class="content-translate">
                            <span
                                v-for="(match, index) in getMatches(
                                    getContentByIndex(i, true)
                                )"
                                :key="index"
                            >
                                <span>
                                    <span
                                        v-html="highlightWords(match.text)"
                                    ></span>
                                </span>
                            </span>
                        </p>
                    </div>
                </section>
            </div>
        </section>

        <section class="div-translation" v-if="showTranslation">
            <p>
                <span>{{ traductionArabic }}</span>
                [<span class="text-color-main">{{ transcriptionArabic }}</span
                >] se traduit par
                <span class="text-color-main">{{ traductionFrancais }}</span
                >.
            </p>
        </section>
    </div>
</template>

<script>
import axios from "axios";
import HeadArticle from "../components/article/HeadArticle.vue";
import ActionsArticle from "../components/article/ActionsArticle.vue";

export default {
    name: "ArticlePage",
    components: { HeadArticle, ActionsArticle },
    data() {
        return {
            numberOfContent: 2,
            fontSize: 38,
            article: {},
            showTranslation: false,
            traductionArabic: "",
            traductionFrancais: "",
            transcriptionArabic: "",
            currentId: null,
            isSwitchedContent: true,
            highlightPropositionsEnabled: false,
            highlightLieuEnabled: false,
            highlightAdjectifEnabled: false,
            dropdownIsShow: false,
            isShowHelp: false,
            buttonConfig: [
                {
                    label: "Prépositions",
                    action: () => this.highlightPropositions(),
                    enabled: () => this.highlightPropositionsEnabled,
                },
                {
                    label: "Lieux",
                    action: () => this.highlightLieu(),
                    enabled: () => this.highlightLieuEnabled,
                },
                {
                    label: "Adjectifs et leur nom",
                    action: () => this.highlightAdjectif(),
                    enabled: () => this.highlightAdjectifEnabled,
                },
            ],
        };
    },
    mounted() {
        this.getArticle();
    },
    computed: {
        numberOfContent() {
            return Object.keys(this.article).filter(
                (key) => key.startsWith("content_") || key === "content"
            ).length;
        },
    },
    methods: {
        getContentByIndex(i, isFrench = false) {
            if (i === 1) {
                return isFrench
                    ? this.article.content_french
                    : this.article.content;
            }
            return isFrench
                ? this.article[`content_${i}_french`]
                : this.article[`content_${i}`];
        },
        changeLanguageContent() {
            this.isSwitchedContent = !this.isSwitchedContent;
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
        highlightPropositions() {
            this.highlightPropositionsEnabled =
                !this.highlightPropositionsEnabled;
        },
        highlightWords(text) {
            if (this.highlightPropositionsEnabled) {
                text = text.replace(
                    /<pp>(.*?)<\/pp>/g,
                    '<span style="color: var(--main-color)">$1</span>'
                );
            }

            if (this.highlightLieuEnabled) {
                text = text.replace(
                    /<lieu>(.*?)<\/lieu>/g,
                    '<span style="padding:5px;background-color: var(--main-color);padding-left:7.5px;padding-right:7.5px;border-radius:12.5px;color:#fbfbfb;">$1</span>'
                );
            }

            if (this.highlightAdjectifEnabled) {
                text = text.replace(
                    /<adj>(.*?)<\/adj>/g,
                    '<span style="padding:5px;padding-left:7.5px;padding-right:7.5px;border-radius:12.5px;border:dotted 2px var(--main-color);">$1</span>'
                );

                text = text.replace(
                    /<adj-nom>(.*?)<\/adj-nom>/g,
                    '<span style="padding:5px;padding-left:7.5px;padding-right:7.5px;border-radius:12.5px;border:solid 2px var(--main-color);">$1</span>'
                );
            }

            return text;
        },
        highlightLieu() {
            this.highlightLieuEnabled = !this.highlightLieuEnabled;
        },
        highlightAdjectif() {
            this.highlightAdjectifEnabled = !this.highlightAdjectifEnabled;
        },
        getMatches(content) {
            if (!content) return [];

            const regex = /<(\d+)>/g;
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
        showDropdown() {
            this.dropdownIsShow = !this.dropdownIsShow;
        },
        showHelp() {
            this.isShowHelp = !this.isShowHelp;
            this.showTranslation = false;
        },
    },
};
</script>

<style lang="scss">
#article-page {
    padding-left: 100px;
    padding-right: 100px;
    padding-top: 0px;
    padding-bottom: 0px;
}
#head-article {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-left: 25px;
    margin-right: 25px;

    font-size: 20px;
}
#actions-article {
    border-radius: 12.5px;
    margin: 25px;

    margin-top: -15px;
}
.btn-1 {
    background-color: #fbfbfb;
    color: #262626;
    border: none;
}
.btn-2 {
    background-color: var(--main-color);
    color: #fbfbfb;
    border: solid 1px var(--main-color);
    margin-left: 25px;
}
.btn-3 {
    background-color: #fbfbfb;
    color: #262626;
    border: none;
    margin-left: 25px;
    font-size: 15px;
}
.rotate-0 {
    transform: rotate(0deg);
}
.input-policy {
    color: var(--main-color);
    font-size: 15px;
    width: 60px;

    margin-left: 15px;
}
.pointer {
    cursor: pointer;
}
.button-selection-words {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 12.5px;
    background-color: #fbfbfb;
    color: #262626;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    letter-spacing: 1px;
    border: solid 1px #fbfbfb;

    cursor: pointer;

    display: flex;
    align-items: center;

    margin-right: 15px;
    margin-top: 20px;
}
.direction-text-right {
    direction: rtl;
}
.section-article {
    padding-left: 40px;
}
input[type="range"] {
    -webkit-appearance: none;
}

input[type="range"]::-webkit-slider-runnable-track {
    width: 300px;
    height: 5px;
    background: #ddd;
    border: none;
    border-radius: 3px;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    border: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: var(--main-color);
    margin-top: -5.5px;
}

input[type="range"]:focus {
    outline: none;
}

input[type="range"]:focus::-webkit-slider-runnable-track {
    background: #ccc;
}

.clickable-number {
    cursor: pointer;
    color: green;
    letter-spacing: normal;

    position: relative;
    top: -20px;
    right: -2px;
    font-size: 15px;
}
.div-translation {
    text-align: center;
    font-size: 25px;
    width: 82.5%;
    border-radius: 12.5px;

    position: fixed;
    top: 10%;
    left: 50%;
    transform: translate(-50%, -50%);

    background-color: #262626;
    color: #fbfbfb;

    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
}
.button-createdAt {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 12.5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    letter-spacing: 1px;

    cursor: pointer;
}

h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 30px;

    img {
        margin-left: 15px;
        transform: rotate(180deg);
        cursor: pointer;
    }
}
.content-translate {
    font-size: 23px;
    line-height: 45px;
    text-align: left;

    padding-left: 15px;
}
</style>
