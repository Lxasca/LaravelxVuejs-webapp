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
                        <section
                            style="
                                display: flex;
                                align-items: center;
                                justify-content: space-evenly;
                            "
                        >
                            <div v-if="switchLanguage">
                                <Label>Titre - Arabe</Label>
                                <Input
                                    type="text"
                                    class="input direction-text-right input-title"
                                    v-model="formData.title"
                                />
                            </div>

                            <div v-else>
                                <Label>Titre - Francais</Label>
                                <Input
                                    type="text"
                                    class="input input-title"
                                    v-model="formData.title_french"
                                />
                            </div>

                            <img
                                @click="toggleLanguage"
                                src="../../../images/exercises/translate.png"
                                width="20px"
                                alt="Changer la langue"
                                class="pointer"
                                style="
                                    margin-top: 40px;
                                    margin-left: 20px;
                                    cursor: pointer;
                                "
                            />
                        </section>
                    </div>

                    <div class="section-article">
                        <section>
                            <div class="grid w-full gap-1.5">
                                <Label for="message-2"
                                    >Paragraphe 1 - Arabe</Label
                                >
                                <p class="text-sm text-muted-foreground">
                                    Mettez en page le paragraphe avec les
                                    différentes options disponibles ci-dessous.
                                </p>

                                <div
                                    style="
                                        margin-top: 5px;
                                        display: flex;
                                        justify-content: start;
                                        margin-bottom: 7px;
                                    "
                                >
                                    <ToggleGroup type="multiple">
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="pp"
                                            @click="wrapSelectionWithPP"
                                        >
                                            Preposition
                                        </ToggleGroupItem>
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="lieu"
                                            @click="wrapSelectionWithLieu"
                                        >
                                            Lieu
                                        </ToggleGroupItem>
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="adj"
                                            @click="wrapSelectionWithAdj"
                                        >
                                            Adjectif
                                        </ToggleGroupItem>
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="adj-nom"
                                            @click="wrapSelectionWithAdjNom"
                                        >
                                            Nom
                                        </ToggleGroupItem>
                                    </ToggleGroup>
                                </div>

                                <Textarea
                                    ref="textarea"
                                    id="message-2"
                                    class="direction-text-right input-learn"
                                    v-model="formData.content"
                                    @mouseup="captureSelection"
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
                                    Mettez en page le paragraphe avec les
                                    différentes options disponibles ci-dessous.
                                </p>

                                <div
                                    style="
                                        margin-top: 5px;
                                        display: flex;
                                        justify-content: start;
                                        margin-bottom: 7px;
                                    "
                                >
                                    <ToggleGroup type="multiple">
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="pp"
                                            @click="wrapSelectionWithPP"
                                        >
                                            Preposition
                                        </ToggleGroupItem>
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="lieu"
                                            @click="wrapSelectionWithLieu"
                                        >
                                            Lieu
                                        </ToggleGroupItem>
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="adj"
                                            @click="wrapSelectionWithAdj"
                                        >
                                            Adjectif
                                        </ToggleGroupItem>
                                        <ToggleGroupItem
                                            class="toggle-group-item"
                                            value="adj-nom"
                                            @click="wrapSelectionWithAdjNom"
                                        >
                                            Nom
                                        </ToggleGroupItem>
                                    </ToggleGroup>
                                </div>

                                <Textarea
                                    id="message-2"
                                    class="direction-text-right input-learn"
                                    v-model="formData.content_2"
                                    @mouseup="captureSelection"
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
                        <Button type="submit">
                            <span v-if="isForm"> Créer l'article</span>
                            <span v-else>Editer l'article</span>
                        </Button>
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
import { Button } from "../../../../src/components/ui/button";
import { Input } from "../../../../src/components/ui/input";
import {
    ToggleGroup,
    ToggleGroupItem,
} from "../../../../src/components/ui/toggle-group";
import { FontBoldIcon, FontItalicIcon, UnderlineIcon } from "@radix-icons/vue";

export default {
    name: "ArticlesPageAdmin",
    components: {
        Input,
        GetArticles,
        Textarea,
        Label,
        ToggleGroup,
        ToggleGroupItem,
        FontBoldIcon,
        FontItalicIcon,
        UnderlineIcon,
        Button,
    },
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
            selection: "",
        };
    },
    mounted() {
        this.getArticles();
        const textarea = this.$refs.textarea;
        if (textarea) {
            textarea.addEventListener("select", this.captureSelection);
        }
    },
    beforeDestroy() {
        const textarea = this.$refs.textarea;
        if (textarea) {
            textarea.removeEventListener("select", this.captureSelection);
        }
    },
    methods: {
        captureSelection() {
            const textarea = this.$refs.textarea.$el || this.$refs.textarea;
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            //console.log(selectedText);
        },
        wrapSelectionWithPP() {
            // selectionne tous les textarea avec la classe .input-learn
            const textareas = document.querySelectorAll(".input-learn");

            textareas.forEach((textarea) => {
                const selection = window.getSelection();
                const selectedText = selection.toString();

                if (selectedText) {
                    const cursorPosition = textarea.selectionStart;
                    const textBefore = textarea.value.substring(
                        0,
                        cursorPosition
                    );
                    const textAfter = textarea.value.substring(
                        textarea.selectionEnd
                    );

                    // Ajouter les balises <pp> autour du texte sélectionné
                    const newText =
                        textBefore +
                        "<pp>" +
                        selectedText +
                        "</pp>" +
                        textAfter;

                    // Mettre à jour la valeur du textarea
                    textarea.value = newText;

                    // Mettre à jour le v-model
                    this.formData.content = newText;

                    // Réinitialiser la sélection
                    const newCursorPosition =
                        cursorPosition +
                        "<pp>".length +
                        selectedText.length +
                        "</pp>".length;
                    textarea.setSelectionRange(
                        newCursorPosition,
                        newCursorPosition
                    );
                }
            });
        },
        wrapSelectionWithLieu() {
            // selectionne tous les textarea avec la classe .input-learn
            const textareas = document.querySelectorAll(".input-learn");

            textareas.forEach((textarea) => {
                const selection = window.getSelection();
                const selectedText = selection.toString();

                if (selectedText) {
                    const cursorPosition = textarea.selectionStart;
                    const textBefore = textarea.value.substring(
                        0,
                        cursorPosition
                    );
                    const textAfter = textarea.value.substring(
                        textarea.selectionEnd
                    );

                    // Ajouter les balises <pp> autour du texte sélectionné
                    const newText =
                        textBefore +
                        "<lieu>" +
                        selectedText +
                        "</lieu>" +
                        textAfter;

                    // Mettre à jour la valeur du textarea
                    textarea.value = newText;

                    // Mettre à jour le v-model
                    this.formData.content = newText;

                    // Réinitialiser la sélection
                    const newCursorPosition =
                        cursorPosition +
                        "<lieu>".length +
                        selectedText.length +
                        "</lieu>".length;
                    textarea.setSelectionRange(
                        newCursorPosition,
                        newCursorPosition
                    );
                }
            });
        },
        wrapSelectionWithAdj() {
            // selectionne tous les textarea avec la classe .input-learn
            const textareas = document.querySelectorAll(".input-learn");

            textareas.forEach((textarea) => {
                const selection = window.getSelection();
                const selectedText = selection.toString();

                if (selectedText) {
                    const cursorPosition = textarea.selectionStart;
                    const textBefore = textarea.value.substring(
                        0,
                        cursorPosition
                    );
                    const textAfter = textarea.value.substring(
                        textarea.selectionEnd
                    );

                    // Ajouter les balises <pp> autour du texte sélectionné
                    const newText =
                        textBefore +
                        "<adj>" +
                        selectedText +
                        "</adj>" +
                        textAfter;

                    // Mettre à jour la valeur du textarea
                    textarea.value = newText;

                    // Mettre à jour le v-model
                    this.formData.content = newText;

                    // Réinitialiser la sélection
                    const newCursorPosition =
                        cursorPosition +
                        "<adj>".length +
                        selectedText.length +
                        "</adj>".length;
                    textarea.setSelectionRange(
                        newCursorPosition,
                        newCursorPosition
                    );
                }
            });
        },
        wrapSelectionWithAdjNom() {
            // selectionne tous les textarea avec la classe .input-learn
            const textareas = document.querySelectorAll(".input-learn");

            textareas.forEach((textarea) => {
                const selection = window.getSelection();
                const selectedText = selection.toString();

                if (selectedText) {
                    const cursorPosition = textarea.selectionStart;
                    const textBefore = textarea.value.substring(
                        0,
                        cursorPosition
                    );
                    const textAfter = textarea.value.substring(
                        textarea.selectionEnd
                    );

                    // Ajouter les balises <pp> autour du texte sélectionné
                    const newText =
                        textBefore +
                        "<adj-nom>" +
                        selectedText +
                        "</adj-nom>" +
                        textAfter;

                    // Mettre à jour la valeur du textarea
                    textarea.value = newText;

                    // Mettre à jour le v-model
                    this.formData.content = newText;

                    // Réinitialiser la sélection
                    const newCursorPosition =
                        cursorPosition +
                        "<adj-nom>".length +
                        selectedText.length +
                        "</adj-nom>".length;
                    textarea.setSelectionRange(
                        newCursorPosition,
                        newCursorPosition
                    );
                }
            });
        },
        ///
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
        ////
    },
};
</script>

<style scoped lang="scss">
/** create **/
#head-article {
    margin-left: 2.5%;
    margin-right: 2.5%;

    display: flex;
    justify-content: end;
    align-items: center;

    font-size: 20px;
}
.section-article {
    margin-bottom: 35px;

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
    font-size: 28px;
    line-height: 50px;
    min-height: 200px;
}
.input-fr {
    font-size: 17px;
    line-height: 25px;

    min-height: 100px;
}
#articles-page {
    padding-left: 50px;
    padding-right: 50px;
    padding-bottom: 45px;
}
.grid {
    margin-bottom: 50px;
}
.toggle-group-item {
    background-color: hsl(var(--secondary));
    color: black;
    font-weight: normal;
    font-size: 13px;
    letter-spacing: 0.7px;

    padding-left: 25px;
    padding-right: 25px;

    margin-right: 5px;
}
.input-title {
    width: 1310px;
    margin-top: 5px;
    font-weight: lighter;

    font-size: 34px;

    padding-top: 35px !important;
    padding-bottom: 35px !important;

    font-weight: 400;
}
</style>
