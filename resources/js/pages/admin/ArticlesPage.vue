<template>
    <div id="articles-page">
        <div>
            <h1>Administration - Articles</h1>
        </div>

        <div>
            <button @click="toggleForm">Créer un article</button>

            <!-- listing de tous les articles -->
            <get-articles
                v-if="!isForm && !isFormEdit"
                :articles="articles"
                :isAdmin="isAdmin"
                @is-form-edit="toggleForm('edit', $event)"
                @form-delete="formDelete($event)"
            ></get-articles>

            <section v-if="isForm || isFormEdit">
                <form @submit.prevent="formSubmit">
                    <div id="head-article">
                        <section>
                            <button class="button-createdAt btn-0">
                                {{ new Date().toLocaleDateString("fr-FR") }}
                            </button>
                        </section>

                        <section>
                            <h5>
                                <input
                                    v-if="switchLanguage"
                                    type="text"
                                    class="input input-titre direction-text-right input-learn"
                                    placeholder="Titre en arabe"
                                    v-model="formData.title"
                                />

                                <input
                                    v-else
                                    type="text"
                                    class="input input-titre input-translate"
                                    placeholder="Titre en français"
                                    v-model="formData.title_french"
                                />

                                <img
                                    @click="toggleLanguage"
                                    src="../../../images/exercises/translate.png"
                                    width="20px"
                                    alt="Changer la langue"
                                    class="pointer"
                                />
                            </h5>
                        </section>
                    </div>

                    <div class="section-article">
                        <section>
                            <div class="grid w-full gap-1.5">
                                <Label for="message-2"
                                    >Paragraphe 1 - Arabe</Label
                                >
                                <p class="text-sm text-muted-foreground">
                                    &lt;pp/&gt;&lt;pp&gt; pour les prépositions,
                                    &lt;lieu/&gt;&lt;lieu&gt; pour les lieux,
                                    &lt;adj/&gt;&lt;adj&gt; pour les adjectifs,
                                    &lt;adj-nom/&gt;&lt;adj-nom&gt; pour les
                                    noms aux quels se réfèrent les adjectifs.
                                </p>

                                <Textarea
                                    id="message-2"
                                    class="direction-text-right input-learn"
                                    v-model="formData.content"
                                />
                            </div>
                        </section>

                        <section>
                            <div class="grid w-full gap-1.5">
                                <Label for="message-2"
                                    >Paragraphe 1 - Francais</Label
                                >
                                <p class="text-sm text-muted-foreground"></p>

                                <Textarea
                                    id="message-2"
                                    class="input-fr"
                                    v-model="formData.content_french"
                                />
                            </div>
                        </section>

                        <div
                            class="d-flex-center"
                            style="margin-bottom: 75px; margin-top: 75px"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-chevrons-up-down"
                            >
                                <path d="m7 15 5 5 5-5" />
                                <path d="m7 9 5-5 5 5" />
                            </svg>
                        </div>

                        <section>
                            <div class="grid w-full gap-1.5">
                                <Label for="message-2"
                                    >Paragraphe 2 - Arabe</Label
                                >
                                <p class="text-sm text-muted-foreground">
                                    &lt;pp/&gt;&lt;pp&gt; pour les prépositions,
                                    &lt;lieu/&gt;&lt;lieu&gt; pour les lieux,
                                    &lt;adj/&gt;&lt;adj&gt; pour les adjectifs,
                                    &lt;adj-nom/&gt;&lt;adj-nom&gt; pour les
                                    noms aux quels se réfèrent les adjectifs.
                                </p>

                                <Textarea
                                    id="message-2"
                                    class="direction-text-right input-learn"
                                    v-model="formData.content_2"
                                />
                            </div>
                        </section>

                        <section>
                            <div class="grid w-full gap-1.5">
                                <Label for="message-2"
                                    >Paragraphe 2 - Français</Label
                                >
                                <p class="text-sm text-muted-foreground"></p>

                                <Textarea
                                    id="message-2"
                                    class="input-fr"
                                    v-model="formData.content_2_french"
                                />
                            </div>
                        </section>
                    </div>

                    <section class="d-flex-center">
                        <button type="submit" class="button-createdAt btn-0">
                            <span v-if="isForm"> Créer </span>
                            <span v-else>Editer</span>
                        </button>
                    </section>
                </form>
            </section>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GetArticles from "../../components/article/GetArticles.vue";
import { Textarea } from "../../../../src/components/ui/textarea";
import { Label } from "../../../../src/components/ui/label";

export default {
    name: "ArticlesPageAdmin",
    components: { GetArticles, Textarea, Label },
    data() {
        return {
            isForm: false,
            isFormEdit: false,
            switchLanguage: false,
            formData: {
                title: "",
                title_french: "",
                content: "",
                content_french: "",
                content_2: "",
                content_2_french: "",
            },
            articles: {},
            isAdmin: true,
        };
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        toggleForm(edit = null, article = null) {
            if (edit === "edit" && article) {
                this.isForm = false;
                this.isFormEdit = true;
                this.formData = { ...article };
            } else {
                this.isFormEdit = false;
                this.isForm = !this.isForm;
                this.formData = {};
            }
        },
        formDelete(articleId) {
            const isAdmin = localStorage.getItem("isAdmin");
            if (isAdmin === "true") {
                axios.delete(`/admin/edit-article/${articleId}`).then(() => {
                    this.articles = this.articles.filter(
                        (article) => article.id !== articleId
                    );
                });
            }
        },
        formSubmit() {
            const isAdmin = localStorage.getItem("isAdmin");
            if (isAdmin === "true") {
                if (this.isForm) {
                    axios
                        .post("/admin/create-article", this.formData)
                        .then(() => {
                            this.formData = {
                                title: "",
                                title_french: "",
                                content: "",
                                content_french: "",
                                content_2: "",
                                content_2_french: "",
                            };

                            this.isForm = false;

                            this.getArticles();
                        });
                } else {
                    axios
                        .put(
                            `/admin/edit-article/${this.formData.id}`,
                            this.formData
                        )
                        .then((response) => {
                            const index = this.articles.findIndex(
                                (article) => article.id === this.formData.id
                            );
                            if (index !== -1) {
                                this.articles[index] = { ...this.formData };
                            }

                            this.isFormEdit = false;
                            this.isForm = false;
                        });
                }
            }
        },
        toggleLanguage() {
            this.switchLanguage = !this.switchLanguage;
        },
        getArticles() {
            axios.get("/get-articles").then((response) => {
                this.articles = response.data.map((article) => ({
                    ...article,
                }));
            });
        },
    },
};
</script>

<style scoped lang="scss">
/** create **/
#head-article {
    margin-left: 2.5%;
    margin-right: 2.5%;

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
.section-article {
    margin-bottom: 35px;

    padding: 27.5px;
    padding-bottom: 0px;
    border-radius: 7.5px;

    padding-left: 2.5%;
    padding-right: 2.5%;
}

/**.input-titre {
    width: 1000px;
}**/
textarea:focus {
    box-shadow: none !important;
}
.input-learn {
    font-size: 30px;
    line-height: 50px;
    min-height: 200px;
}
.input-fr {
    font-size: 17px;
    line-height: 25px;

    min-height: 100px;
}
.input-translate {
    font-size: 20px;
}

#articles-page {
    padding-left: 50px;
    padding-right: 50px;
}
.grid {
    margin-bottom: 50px;
}
</style>
