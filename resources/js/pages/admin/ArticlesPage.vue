<template>
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
                        <textarea
                            class="input input-content direction-text-right input-learn"
                            placeholder="Paragraphe 1 en arabe"
                            v-model="formData.content"
                        ></textarea>
                    </section>

                    <section>
                        <textarea
                            class="input input-content input-translate"
                            placeholder="Paragraphe 1 en français"
                            v-model="formData.content_french"
                        ></textarea>
                    </section>

                    <section>
                        <textarea
                            class="input input-content direction-text-right input-learn"
                            placeholder="Paragraphe 2 en arabe"
                            v-model="formData.content_2"
                        ></textarea>
                    </section>

                    <section>
                        <textarea
                            class="input input-content input-translate"
                            placeholder="Paragraphe 2 en français"
                            v-model="formData.content_2_french"
                        ></textarea>
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
</template>

<script>
import axios from "axios";
import GetArticles from "../../components/article/GetArticles.vue";

export default {
    name: "ArticlesPageAdmin",
    components: { GetArticles },
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
            axios.delete(`/admin/edit-article/${articleId}`).then(() => {
                this.articles = this.articles.filter(
                    (article) => article.id !== articleId
                );
            });
        },
        formSubmit() {
            if (this.isForm) {
                axios.post("/admin/create-article", this.formData).then(() => {
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
    margin-left: 2.5%;
    margin-right: 2.5%;

    border-radius: 7.5px;

    background-color: #fbfbfb;
    margin-bottom: 35px;

    padding: 27.5px;
    padding-bottom: 0px;
    border-radius: 7.5px;

    padding-left: 2.5%;
    padding-right: 2.5%;

    textarea {
        width: 100%;
        margin-bottom: 27.5px;

        padding: 5px;
        min-height: 150px;
    }
}

.input-titre {
    width: 1000px;
}

input,
textarea {
    background-color: transparent;
    border: none;
    outline: none;
    //box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 7.5px;
}

.input-learn {
    font-size: 38px;
}
.input-translate {
    font-size: 20px;
}
</style>
