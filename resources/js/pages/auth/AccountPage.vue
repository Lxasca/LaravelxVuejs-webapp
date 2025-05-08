<template>
    <div
        style="padding-left: 6.75%; padding-right: 6.75%; padding-bottom: 80px"
    >
        <h1>
            Mon
            <span style="color: #58ca60; font-weight: bold">compte</span>
        </h1>

        <div style="display: flex; justify-content: center">
            <button @click="logout" style="margin-left: 300px">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-log-out-icon lucide-log-out"
                >
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
            </button>
        </div>

        <div style="text-align: center">
            <span v-if="boolComparePassword == 'success'">Bravo ! </span>
            <span v-else-if="boolComparePassword == 'error'">Oup's ! </span>
            <span> {{ returnComparePassword }}</span>
        </div>

        <form @submit.prevent="comparePassword">
            <div
                style="display: flex; justify-content: center; margin-top: 25px"
            >
                <div style="width: 372.5px">
                    <Input type="email" :placeholder="email" disabled />
                    <br />

                    <section
                        style="display: flex; justify-content: space-between"
                    >
                        <Input
                            type="password"
                            :value="passwordLength"
                            disabled
                            style="width: 85%"
                        />
                        <p @click="showModifPassword">
                            <span style="display: flex; align-items: center">
                                <Button type="submit">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-square-pen-icon lucide-square-pen"
                                    >
                                        <path
                                            d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                                        />
                                        <path
                                            d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"
                                        />
                                    </svg>
                                </Button>
                            </span>
                        </p>
                    </section>

                    <Input
                        v-if="isShowModifPassword"
                        type="password"
                        placeholder="Nouveau mot de passe"
                        v-model="newPassword"
                        style="margin-top: 23px"
                        @input="controlPassword(newPassword)"
                    />
                    <span v-if="!booleanControlPassword && isShowModifPassword">
                        {{ textControlPassword }}
                    </span>

                    <p></p>
                </div>
            </div>

            <div style="display: flex; justify-content: center">
                <div
                    v-if="isShowModifPassword"
                    style="display: flex; margin-top: 20px"
                >
                    <Button
                        style="margin-right: 5px"
                        type="submit"
                        :disabled="!booleanControlPassword"
                        >Sauvegarder</Button
                    >
                    <Button
                        variant="secondary"
                        @click="showModifPassword"
                        style="margin-left: 5px"
                        >Annuler</Button
                    >
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import axios from "axios";
import { Input } from "../../../../src/components/ui/input";
import { Button } from "../../../../src/components/ui/button";

export default {
    name: "AccountPage",
    components: { Input, Button },
    data() {
        return {
            email: localStorage.getItem("email") || "",
            passwordLength: 0,
            isAuthenticated: true,
            isShowModifPassword: false,
            newPassword: "",
            booleanControlPassword: false,
            textControlPassword: "",
            boolComparePassword: "",
            returnComparePassword: "",
        };
    },
    mounted() {
        this.getLengthPassword();
    },
    methods: {
        controlPassword(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasDigit = /\d/.test(password);

            let conditions = [];

            if (password.length < minLength) {
                conditions.push("8 caractères");
            }
            if (!hasUpperCase) {
                conditions.push("une majuscule");
            }
            if (!hasLowerCase) {
                conditions.push("une minuscule");
            }
            if (!hasDigit) {
                conditions.push("un chiffre");
            }

            if (conditions.length > 0) {
                this.textControlPassword =
                    "Votre mot de passe doit contenir au moins " +
                    conditions.join(", ") +
                    ".";
            } else {
                this.textControlPassword = "";
            }

            this.booleanControlPassword =
                password.length >= minLength &&
                hasUpperCase &&
                hasLowerCase &&
                hasDigit;

            if (this.booleanControlPassword === true) {
                this.textControlPassword =
                    "Bravo, votre mot de passe est valide car très sécurisé.";
            }
        },
        comparePassword() {
            axios
                .post("/compare-password", { newPassword: this.newPassword })
                .then((response) => {
                    if (response.data.match) {
                        this.boolComparePassword = "error";
                        this.returnComparePassword =
                            "Le nouveau mot de passe saisi est identique au premier.";
                    } else {
                        if (this.booleanControlPassword === true) {
                            axios
                                .put("/update-password", {
                                    email: this.email,
                                    newPassword: this.newPassword,
                                })
                                .then((response) => {
                                    this.boolComparePassword = "success";
                                    this.returnComparePassword =
                                        "Votre mot de passe a été modifié avec succès.";

                                    // Je vide le champ newPassword, je le cache, et j'upadte le champ password
                                    this.newPassword = "";
                                    this.isShowModifPassword = false;
                                    this.getLengthPassword();
                                })
                                .catch((error) => {
                                    this.boolComparePassword = "error";
                                    this.returnComparePassword =
                                        "Une erreur est survenue lors du changement de votre mot de passe.";
                                });
                        }
                    }
                })
                .catch((error) => {
                    this.boolComparePassword = "error";
                    this.returnComparePassword =
                        "Une erreur est survenue lors du changement de votre mot de passe.";
                });
        },
        showModifPassword() {
            this.isShowModifPassword = !this.isShowModifPassword;
        },
        getLengthPassword() {
            axios
                .get("/get-length-password", {
                    params: { email: this.email },
                })
                .then((response) => {
                    this.passwordLength = "•".repeat(
                        response.data.password_length
                    );
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        logout() {
            localStorage.removeItem("isAdmin");
            localStorage.removeItem("isClient");
            localStorage.removeItem("isUser");
            localStorage.removeItem("email");
            this.isAuthenticated = false;

            this.$router.push({ name: "authentification" });
        },
    },
};
</script>
<style scoped>
@media (max-width: 767px) {
    h1 {
        font-size: 65px;
    }
}
</style>
