<template>
    <div style="padding-left: 6.75%; padding-right: 6.75%">
        <h1>
            Mon <span style="color: #58ca60; font-weight: bold">compte</span>
        </h1>

        <div style="display: flex; justify-content: center; margin-top: 25px">
            <div style="width: 372.5px">
                <Input type="email" :placeholder="email" disabled />
                <br />

                <section style="display: flex; justify-content: space-between">
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

                <form @submit.prevent="comparePassword">
                    <Input
                        v-if="isShowModifPassword"
                        type="password"
                        placeholder="Nouveau mot de passe"
                        v-model="newPassword"
                        style="margin-top: 15px"
                    />
                </form>
            </div>
        </div>

        <div style="display: flex; justify-content: center">
            <div
                v-if="isShowModifPassword"
                style="display: flex; margin-top: 20px"
            >
                <Button style="margin-right: 5px" type="submit"
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
    </div>
</template>
<script>
import axios from "axios";
import { Input } from "../../../src/components/ui/input";
import { Button } from "../../../src/components/ui/button";

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
        };
    },
    mounted() {
        this.getLengthPassword();
    },
    methods: {
        comparePassword() {
            console.log("lleaaa");
            axios
                .post("/compare-password", { newPassword: this.newPassword })
                .then((response) => {
                    if (response.data.match) {
                        console.log("Les mots de passe sont identiques.");
                    } else {
                        console.log(
                            "Les mots de passe sont différents. Mise à jour en cours..."
                        );
                        axios
                            .put("/api/update-password", {
                                newPassword: this.newPassword,
                            })
                            .then(() =>
                                console.log(
                                    "Mot de passe mis à jour avec succès !"
                                )
                            );
                    }
                })
                .catch((error) => {
                    console.error("Erreur :", error);
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
    },
};
</script>
<style scoped></style>
