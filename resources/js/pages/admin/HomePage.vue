<template>
    <div>
        <br />

        <div v-if="isAuthenticated">
            <router-link :to="{ name: 'admin-articles' }"
                >Administration articles</router-link
            >
            <br />
            <button @click="logout">Déconnexion</button>
        </div>

        <div v-else>
            <h1 style="text-align: center">
                <span v-if="!showRegister">Connexion</span>
                <span v-else>Inscription</span>
            </h1>
            <br />

            <div class="flex-center">
                <section
                    style="
                        width: 372.5px;
                        margin-left: -28.5px;
                        align-items: center;
                        display: flex;
                    "
                >
                    <Input
                        type="email"
                        v-model="email"
                        placeholder="Adresse électronique"
                    />
                </section>
            </div>

            <br />

            <div class="flex-center">
                <section class="section-password">
                    <Input
                        :type="passwordVisible ? 'text' : 'password'"
                        v-model="password"
                        placeholder="Mot de passe"
                        style="margin-right: 10px"
                    />
                    <span
                        v-if="passwordVisible"
                        style="cursor: pointer"
                        @click="togglePasswordVisible"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye"
                        >
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    <span
                        v-else
                        style="cursor: pointer"
                        @click="togglePasswordVisible"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye-off"
                        >
                            <path
                                d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"
                            />
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                            <path
                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"
                            />
                            <path d="m2 2 20 20" />
                        </svg>
                    </span>
                </section>
            </div>

            <div
                v-if="showRegister"
                class="flex-center"
                style="margin-top: 10px"
            >
                <section class="section-password">
                    <Input
                        :type="confirmPasswordVisible ? 'text' : 'password'"
                        v-model="confirmPassword"
                        placeholder="Confirmer le mot de passe"
                        style="margin-right: 10px"
                    />
                    <span
                        v-if="confirmPasswordVisible"
                        style="cursor: pointer"
                        @click="toggleConfirmPasswordVisible"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye"
                        >
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    <span
                        v-else
                        style="cursor: pointer"
                        @click="toggleConfirmPasswordVisible"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye-off"
                        >
                            <path
                                d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"
                            />
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                            <path
                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"
                            />
                            <path d="m2 2 20 20" />
                        </svg>
                    </span>
                </section>
            </div>

            <br />

            <div class="flex-center">
                <Button
                    v-if="!showRegister"
                    @click="connexion"
                    style="margin-left: 11px"
                    >Se connecter</Button
                >
                <Button v-else @click="connexion" style="margin-left: 11px"
                    >S'inscrire</Button
                >
            </div>

            <br />
            <div class="flex-center">
                <button v-if="!showRegister" @click="changeShowRegister">
                    Pas encore inscrit(e) ? Inscrivez-vous
                </button>
                <button v-else @click="changeShowRegister">
                    Déjà inscrit(e) ? Connectez-vous
                </button>
            </div>

            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { Input } from "../../../../src/components/ui/input";
import { Button } from "../../../../src/components/ui/button";

export default {
    components: { Input, Button },
    data() {
        return {
            password: "",
            confirmPassword: "",
            email: "",
            isAuthenticated: localStorage.getItem("isAdmin") === "true",
            errorMessage: "",
            passwordVisible: false,
            confirmPasswordVisible: false,
            showRegister: false,
        };
    },
    methods: {
        changeShowRegister() {
            this.showRegister = !this.showRegister;
        },
        inscription() {
            axios
                .post("/inscription", {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    console.log(response.data.message);

                    if (response.data.message === "Inscription réussie.") {
                        this.isAuthenticated = true;
                        localStorage.setItem("isAdmin", "true");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        connexion() {
            axios
                .get("/connexion", {
                    params: { email: this.email, password: this.password },
                })
                .then((response) => {
                    console.log(response.data.message);

                    if (response.data.message === "Authentification réussie.") {
                        this.isAuthenticated = true;
                        localStorage.setItem("isAdmin", "true");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logout() {
            localStorage.removeItem("isAdmin");
            this.isAuthenticated = false;
        },
        togglePasswordVisible() {
            this.passwordVisible = !this.passwordVisible;
        },
        toggleConfirmPasswordVisible() {
            this.confirmPasswordVisible = !this.confirmPasswordVisible;
        },
    },
};
</script>

<style scoped>
.error {
    color: red;
    margin-top: 10px;
}
.flex-center {
    display: flex;
    justify-content: center;
}
.section-password {
    width: 400px;
    align-items: center;
    display: flex;
}
</style>
