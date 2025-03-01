<template>
    <div>
        <h1>Mon compte</h1>
        <p><strong>Adresse e-mail :</strong> {{ email }}</p>

        <label>Mot de passe</label>
        <Input type="password" :value="passwordLength" readonly />
        <label>Nouveau mot de passe</label>
        <Input type="password" />

        <Button>Sauvegarder</Button>
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
        };
    },
    mounted() {
        this.getLengthPassword();
    },
    methods: {
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
