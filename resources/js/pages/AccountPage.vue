<template>
    <div>
        <h1>
            Mon <span style="color: #ffc300; font-weight: bold">compte</span>
        </h1>

        <button @click="logout">Déconnexion</button>

        <div style="display: flex; justify-content: center">
            <div style="width: 372.5px">
                <Input type="email" :placeholder="email" readonly />
                <br />
                <Input
                    v-if="!isShowModifPassword"
                    type="password"
                    :value="passwordLength"
                    readonly
                />

                <Input
                    v-else
                    type="password"
                    placeholder="Nouveau mot de passe"
                />
            </div>
        </div>

        <p
            style="
                text-align: center;
                color: black;
                margin-top: 10px;
                cursor: pointer;
            "
            @click="showModifPassword"
        >
            <span v-if="!isShowModifPassword">Modifier mon mot de passe</span>
            <div style="display:flex">
                <Button v-if="isShowModifPassword">Sauvegarder</Button>
            <p v-if="isShowModifPassword" @click="showModifPassword"
                >Annuler</p
            >
            </div>
        </p>
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
        };
    },
    mounted() {
        this.getLengthPassword();
    },
    methods: {
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
