<template>
    <div id="article-page">
        <section
            :style="{
                fontSize: fontSize + 'px',
                lineHeight: fontSize * 1.8 + 'px',
            }"
        >
            <div>
                <!-- La date à gauche, le titre et sa traduction à droite -->
                <head-article :article="article"></head-article>

                <!-- les actions possibles sur le contenu de l'article -->
                <actions-article
                    v-model:fontSize="fontSize"
                    v-model:isShowHelp="isShowHelp"
                    v-model:showTranslation="showTranslation"
                    v-model:isSwitchedContent="isSwitchedContent"
                    :buttonConfig="buttonConfig"
                    style="margin-top: 22.5px; margin-bottom: 35px"
                ></actions-article>

                <!-- article -->
                <section class="section-article">
                    <div
                        v-for="i in numberOfContent"
                        :key="i"
                        style="margin-bottom: 40px"
                    >
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
                                    <AlertDialog v-if="isShowHelp">
                                        <AlertDialogTrigger>
                                            <button>
                                                <svg
                                                    style="
                                                        margin-left: 2.5px;
                                                        margin-right: 2.5px;
                                                    "
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="var(--main-color)"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-hand-icon lucide-hand"
                                                >
                                                    <path
                                                        d="M18 11V6a2 2 0 0 0-2-2a2 2 0 0 0-2 2"
                                                    />
                                                    <path
                                                        d="M14 10V4a2 2 0 0 0-2-2a2 2 0 0 0-2 2v2"
                                                    />
                                                    <path
                                                        d="M10 10.5V6a2 2 0 0 0-2-2a2 2 0 0 0-2 2v8"
                                                    />
                                                    <path
                                                        d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"
                                                    />
                                                </svg>
                                            </button>
                                        </AlertDialogTrigger>
                                        <AlertDialogContent>
                                            <AlertDialogHeader
                                                class="divTranslation"
                                            >
                                                <AlertDialogTitle
                                                    style="font-size: 45px"
                                                >
                                                    <span>{{
                                                        traductionArabic
                                                    }}</span></AlertDialogTitle
                                                >
                                                <AlertDialogDescription
                                                    style="margin-top: 15px"
                                                >
                                                    <span
                                                        style="
                                                            font-size: 25px;
                                                            font-style: italic;
                                                        "
                                                        >{{
                                                            transcriptionArabic
                                                        }}</span
                                                    >
                                                </AlertDialogDescription>
                                                <AlertDialogTitle
                                                    style="
                                                        font-size: 30px;
                                                        margin-top: 25px;
                                                    "
                                                >
                                                    <span
                                                        style="
                                                            font-weight: bold;
                                                        "
                                                        >{{
                                                            traductionFrancais
                                                        }}</span
                                                    ></AlertDialogTitle
                                                >
                                            </AlertDialogHeader>
                                            <AlertDialogFooter>
                                                <AlertDialogAction
                                                    style="margin-top: 15px"
                                                    >J'ai compris !
                                                </AlertDialogAction>
                                            </AlertDialogFooter>
                                        </AlertDialogContent>
                                    </AlertDialog>
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

                <!-- vers exercice -->
                <section
                    style="
                        display: flex;
                        justify-content: center;
                        margin-bottom: 75px;
                    "
                >
                    <RouterLink
                        :to="{
                            name: 'exercice',
                            params: { article_id: $route.params.article_id },
                        }"
                    >
                        <Button>
                            Démarrer le quizz d'apprentissage du vocabulaire
                        </Button>
                    </RouterLink>
                </section>
            </div>
        </section>
    </div>
</template>

<script>
import axios from "axios";
import HeadArticle from "../components/article/HeadArticle.vue";
import ActionsArticle from "../components/article/ActionsArticle.vue";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "../../../src/components/ui/alert-dialog";
import { Button } from "../../../src/components/ui/button";

export default {
    name: "ArticlePage",
    components: {
        HeadArticle,
        ActionsArticle,
        AlertDialog,
        AlertDialogAction,
        AlertDialogCancel,
        AlertDialogContent,
        AlertDialogDescription,
        AlertDialogFooter,
        AlertDialogHeader,
        AlertDialogTitle,
        AlertDialogTrigger,
        Button,
    },
    data() {
        return {
            numberOfContent: 2,
            fontSize: 34,
            article: {},
            showTranslation: false,
            traductionArabic: "",
            traductionFrancais: "",
            transcriptionArabic: "",
            currentId: null,
            isSwitchedContent: true,
            highlightPropositionsEnabled: true,
            highlightLieuEnabled: true,
            highlightAdjectifEnabled: true,
            highlightVerbeEnabled: true,
            highlightAnnexionEnabled: true,
            isShowHelp: true,
            buttonConfig: [
                {
                    label: "Prépositions",
                    action: () => this.highlightPropositions(),
                    enabled: () => this.highlightPropositionsEnabled,
                    tooltip: "Colorer les prépositions",
                },
                {
                    label: "Lieux",
                    action: () => this.highlightLieu(),
                    enabled: () => this.highlightLieuEnabled,
                    tooltip: "Entourer les noms de lieux",
                },
                {
                    label: "Adjectifs - noms",
                    action: () => this.highlightAdjectif(),
                    enabled: () => this.highlightAdjectifEnabled,
                    tooltip:
                        "Souligner les adjectifs avec des pointillés et les noms qui s'y réfèrent avec une ligne",
                },
                {
                    label: "Verbes",
                    action: () => this.highlightVerbe(),
                    enabled: () => this.highlightVerbeEnabled,
                    tooltip: "Entourer les verbes avec des pointillés.",
                },
                {
                    label: "Annexions",
                    action: () => this.highlightAnnexion(),
                    enabled: () => this.highlightAnnexionEnabled,
                    tooltip: "Souligner de deux traits les annexions.",
                },
            ],
            vocabularies: {},
        };
    },
    mounted() {
        this.getArticle();
        this.getMatches();
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
                    '<span style="color: var(--main-color);">$1</span>'
                );
            }

            if (this.highlightLieuEnabled) {
                text = text.replace(
                    /<lieu>(.*?)<\/lieu>/g,
                    '<span style="padding-left:8.5px;padding-right:8.5px;padding-top:4.5px;padding-bottom:4.5px;background-color: var(--main-color);border-radius:10px;color:white;">$1</span>'
                );
            }

            if (this.highlightAdjectifEnabled) {
                text = text.replace(
                    /<adj>(.*?)<\/adj>/g,
                    '<span style="padding-left:5px;padding-right:5px;border-bottom:dotted 2px var(--main-color);">$1</span>'
                );

                text = text.replace(
                    /<adj-nom>(.*?)<\/adj-nom>/g,
                    '<span style="padding-left:5px;padding-right:5px;border-bottom:solid 2px var(--main-color);">$1</span>'
                );
            }

            if (this.highlightVerbeEnabled) {
                text = text.replace(
                    /<verbe>(.*?)<\/verbe>/g,
                    '<span style="padding-left:5px;padding-right:5px;border:dotted 2px black;;border-radius:10px;">$1</span>'
                );
            }

            if (this.highlightAnnexionEnabled) {
                text = text.replace(
                    /<annexion>(.*?)<\/annexion>/g,
                    '<span style="text-decoration-color:var(--main-color);text-decoration-line:underline;text-decoration-style: wavy;text-decoration-thickness: 1px;text-underline-offset: 17.5px;">$1</span>'
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
        highlightVerbe() {
            this.highlightVerbeEnabled = !this.highlightVerbeEnabled;
        },
        highlightAnnexion() {
            this.highlightAnnexionEnabled = !this.highlightAnnexionEnabled;
        },
        getMatches(content) {
            if (!content) return [];

            const regex = /<(\d+)>/g;
            let match;
            const matches = [];
            let lastIndex = 0;
            const ids = [];

            while ((match = regex.exec(content)) !== null) {
                if (match.index > lastIndex) {
                    matches.push({
                        text: content.slice(lastIndex, match.index),
                    });
                }

                if (!ids.includes(match[1])) {
                    ids.push(match[1]);
                }

                matches.push({ text: match[1], type: "number", id: match[1] });

                lastIndex = regex.lastIndex;
            }

            if (lastIndex < content.length) {
                matches.push({ text: content.slice(lastIndex) });
            }

            // requetes axios pour stocker dans this.vocabularies les data, pour éviter de requete à chaque ouverte de la modale
            ids.forEach((id) => {
                axios.get(`/get-vocabulary/${id}`).then((response) => {
                    this.vocabularies[id] = {
                        traductionArabic: response.data.traduction_arabic,
                        traductionFrancais:
                            response.data.word.charAt(0).toLowerCase() +
                            response.data.word.slice(1),
                        transcriptionArabic: response.data.transcription_arabic,
                        currentId: id,
                        showTranslation: true,
                    };
                });
            });

            return matches;
        },
        handleClick(id) {
            if (this.currentId === id && this.showTranslation) {
                this.showTranslation = false;
                return;
            }

            const vocab = this.vocabularies[id];
            if (vocab) {
                this.traductionArabic = vocab.traductionArabic;
                this.traductionFrancais = vocab.traductionFrancais;
                this.transcriptionArabic = vocab.transcriptionArabic;
                this.currentId = id;
                this.showTranslation = true;
            }
        },
        showHelp() {
            this.isShowHelp = !this.isShowHelp;
            this.showTranslation = false;
        },
    },
};
</script>

<style lang="scss">
@media (max-width: 767px) {
    .direction-text-right {
        font-size: 35px;
        line-height: 57.5px;
    }

    #article-page {
        padding-left: 3% !important;
        padding-right: 0% !important;
    }
}
#article-page {
    padding-left: 4%;
    padding-right: 5%;

    padding-top: 0px;
    padding-bottom: 0px;
}

.rotate-0 {
    transform: rotate(0deg);
}
.section-article {
    padding-left: 10px;
    padding-right: 35px;

    margin-top: 40px;

    padding-bottom: 50px;
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
.divTranslation {
    padding-top: 25px;
    text-align: center;
}

h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 34px;

    img {
        margin-left: 15px;
        transform: rotate(180deg);
        cursor: pointer;
    }
}
.content-translate {
    font-size: 20px;
    line-height: 30px;
    text-align: left;

    padding-left: 25px;
    margin-top: 15px;
}
</style>
