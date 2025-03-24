<template>
    <div style="padding-left: 6.75%; padding-right: 6.75%">
        <h1>
            Mon <span style="color: #ffc300; font-weight: bold">compte</span>
        </h1>

        <section
            style="text-align: center; margin-top: -25px; margin-right: -75px"
        >
            <button @click="logout" style="font-style: italic">
                Déconnexion
            </button>
        </section>

        <div style="display: flex; justify-content: center; margin-top: 50px">
            <div style="width: 372.5px">
                <Input type="email" :placeholder="email" readonly />
                <br />
                <Input
                    v-if="!isShowModifPassword"
                    type="password"
                    :value="passwordLength"
                    readonly
                />

                <form @submit.prevent="comparePassword">
                    <Input
                        v-if="isShowModifPassword"
                        type="password"
                        placeholder="Nouveau mot de passe"
                        v-model="newPassword"
                    />
                </form>
            </div>
        </div>

        <div style="display: flex; justify-content: center">
            <p
                style="
                    text-align: center;
                    color: black;
                    margin-top: 10px;
                    cursor: pointer;
                "
                @click="showModifPassword"
            >
                <span v-if="!isShowModifPassword"
                    >Modifier mon mot de passe</span
                >
            </p>

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
<style scoped></style>
