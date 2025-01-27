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
                <div id="head-article">
                    <section>
                        <button class="button-createdAt btn-0">
                            {{
                                new Date(article.created_at).toLocaleDateString(
                                    "fr-FR"
                                )
                            }}
                        </button>
                    </section>

                    <section>
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
                </div>

                <!-- les actions possibles sur le contenu de l'article -->
                <div id="actions-article">
                    <!-- -->
                    <div class="d-flex-between">
                        <section class="d-flex-align">
                            <button
                                class="button-createdAt d-flex-align btn-1"
                                @click="showDropdown"
                            >
                                Colorier les ...

                                <img
                                    src="../../images/exercises/right.png"
                                    class="ml-10"
                                    :style="
                                        dropdownIsShow
                                            ? {
                                                  transform: 'rotate(90deg)',
                                              }
                                            : { transform: 'rotate(0deg)' }
                                    "
                                />
                            </button>

                            <button
                                class="button-createdAt d-flex-align btn-2"
                                @click="showHelp"
                            >
                                <span v-if="isShowHelp">
                                    Retirer les aides vocabulaires
                                </span>
                                <span v-else
                                    >Afficher les aides vocabulaires</span
                                >
                                <img
                                    src="../../images/exercises/interrogation.png"
                                    alt=""
                                    class="ml-10 rotate-0"
                                />
                            </button>

                            <button class="button-createdAt d-flex-align btn-3">
                                <span> Taille de la police </span>
                                <input
                                    type="number"
                                    v-model.number="fontSize"
                                    min="40"
                                    class="input-policy"
                                />
                            </button>
                        </section>

                        <img
                            @click="changeLanguageContent()"
                            src="../../images/exercises/translate.png"
                            width="20px"
                            alt=""
                            class="pointer"
                        />
                    </div>
                    <div class="d-flex-start">
                        <section v-if="dropdownIsShow" class="d-flex-start">
                            <button
                                v-for="(item, index) in buttonConfig"
                                :key="index"
                                class="button-selection-words"
                                @click="item.action"
                                :style="
                                    item.enabled ? { color: '#fc5134' } : {}
                                "
                            >
                                {{ item.label }}
                            </button>

                            <!-- -->

                            <button
                                class="button-selection-words"
                                @click="highlightPropositions"
                                :style="
                                    highlightPropositionsEnabled
                                        ? {
                                              color: '#fc5134',
                                          }
                                        : {}
                                "
                            >
                                Prépositions
                            </button>
                            <button
                                class="button-selection-words"
                                @click="highlightLieu"
                                :style="
                                    highlightLieuEnabled
                                        ? {
                                              color: '#fc5134',
                                          }
                                        : {}
                                "
                            >
                                Lieux
                            </button>
                            <button
                                class="button-selection-words"
                                @click="highlightAdjectif"
                                :style="
                                    highlightAdjectifEnabled
                                        ? {
                                              color: '#fc5134',
                                          }
                                        : {}
                                "
                            >
                                Adjectifs et leur nom
                            </button>
                        </section>
                    </div>
                </div>

                <!-- article -->

                <section>
                    <!-- content 1 -->
                    <p style="direction: rtl">
                        <span
                            :style="{ unicodeBidi: 'plaintext' }"
                            v-for="(match, index) in getMatches(
                                article.content
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

                                <!--{{ match.text }}-->
                            </span>

                            <span v-else>
                                <span
                                    v-html="highlightWords(match.text)"
                                ></span>
                            </span>
                        </span>
                    </p>
                    <p v-if="isSwitchedContent" id="content-french">
                        <span
                            v-for="(match, index) in getMatches(
                                article.content_french
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
                    <!-- content 2 -->
                    <p style="direction: rtl">
                        <span
                            :style="{ unicodeBidi: 'plaintext' }"
                            v-for="(match, index) in getMatches(
                                article.content_2
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

                                <!--{{ match.text }}-->
                            </span>

                            <span v-else>
                                <span
                                    v-html="highlightWords(match.text)"
                                ></span>
                            </span>
                        </span>
                    </p>
                    <p v-if="isSwitchedContent" id="content-french">
                        <span
                            v-for="(match, index) in getMatches(
                                article.content_2_french
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
                </section>
            </div>
        </section>

        <section class="div-translation" v-if="showTranslation">
            <p style="margin-top: 35px">
                <span>{{ traductionArabic }}</span>
                [<span style="color: #fc5134">{{ transcriptionArabic }}</span
                >] se traduit par
                <span style="font-weight: bold; color: #fc5134">{{
                    traductionFrancais
                }}</span
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
            fontSize: 40,
            article: {},
            showTranslation: false,
            traductionArabic: "",
            traductionFrancais: "",
            transcriptionArabic: "",
            currentId: null,
            isSwitched: false,
            isSwitchedContent: false,
            highlightPropositionsEnabled: false,
            highlightLieuEnabled: false,
            highlightAdjectifEnabled: false,
            dropdownIsShow: false,
            isShowHelp: false,
            buttonConfig: [
                {
                    label: "Prépositions",
                    action: () => this.highlightPropositions(),
                    enabled: false,
                },
                {
                    label: "Lieux",
                    action: () => this.highlightLieu(),
                    enabled: false,
                },
                {
                    label: "Adjectifs et leur nom",
                    action: () => this.highlightAdjectif(),
                    enabled: false,
                },
            ],
        };
    },
    mounted() {
        this.getArticle();
    },
    methods: {
        changeLanguage() {
            this.isSwitched = !this.isSwitched;
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
                    '<span style="color: #fc5134">$1</span>'
                );
            }

            if (this.highlightLieuEnabled) {
                text = text.replace(
                    /<lieu>(.*?)<\/lieu>/g,
                    '<span style="padding:5px;background-color: #fc5134;padding-left:7.5px;padding-right:7.5px;border-radius:12.5px;color:#fbfbfb;">$1</span>'
                );
            }

            if (this.highlightAdjectifEnabled) {
                text = text.replace(
                    /<adj>(.*?)<\/adj>/g,
                    '<span style="padding:5px;padding-left:7.5px;padding-right:7.5px;border-radius:12.5px;border:dotted 2px #fc5134;">$1</span>'
                );

                text = text.replace(
                    /<adj-nom>(.*?)<\/adj-nom>/g,
                    '<span style="padding:5px;padding-left:7.5px;padding-right:7.5px;border-radius:12.5px;border:solid 2px #fc5134;">$1</span>'
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

<style scoped lang="scss">
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
.btn-0 {
    background-color: #262626;
    color: #fbfbfb;
    border: none;
}
.btn-1 {
    background-color: #fbfbfb;
    color: #262626;
    border: none;
}
.btn-2 {
    background-color: #fc5134;
    color: #fbfbfb;
    border: solid 1px #fc5134;
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
    color: #fc5134;
    font-size: 15px;
    width: 60px;
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
/********/
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
    width: 76%;
    height: 14.5%;

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
#title-french {
    font-size: 22.5px;
}
#content-french {
    font-size: 24px;
    line-height: 45px;
    text-align: left;

    padding-left: 15px;
}
</style>
