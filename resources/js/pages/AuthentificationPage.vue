<template>
    <div>
        <!-- refonte avec TABS -->
        <div style="display: flex; justify-content: center">
            <Tabs default-value="account" style="width: 450px">
                <TabsList
                    class="grid grid-cols-2"
                    style="
                        display: flex;
                        justify-content: space-between;
                        width: 382px;
                        margin-left: 20px;
                    "
                >
                    <TabsTrigger value="account" style="width: 50%">
                        Connexion
                    </TabsTrigger>
                    <TabsTrigger value="password" style="width: 50%">
                        Inscription
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="account">
                    <Card>
                        <CardHeader>
                            <CardTitle>Connexion</CardTitle>
                            <CardDescription
                                v-if="textControlConnexion == null"
                            >
                                Connectez-vous pour accéder à votre espace
                                personnel.
                            </CardDescription>
                            <CardDescription v-else>
                                <Alert variant="destructive" class="mt-4">
                                    <AlertCircle class="w-4 h-4" />
                                    <AlertTitle>Oup's ...</AlertTitle>
                                    <AlertDescription>
                                        {{ textControlConnexion }}
                                    </AlertDescription>
                                </Alert>
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
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
                                        @blur="controlValidEmail(email)"
                                    />
                                </section>
                            </div>

                            <CardDescription
                                style="margin-left: 3px; margin-top: 5px"
                            >
                                {{ textControlEmail }}
                            </CardDescription>

                            <br />
                            <div class="flex-center">
                                <section class="section-password">
                                    <Input
                                        :type="
                                            passwordVisible
                                                ? 'text'
                                                : 'password'
                                        "
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
                                            <path
                                                d="M14.084 14.158a3 3 0 0 1-4.242-4.242"
                                            />
                                            <path
                                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"
                                            />
                                            <path d="m2 2 20 20" />
                                        </svg>
                                    </span>
                                </section>
                            </div>
                        </CardContent>
                        <CardFooter
                            style="display: flex; justify-content: center"
                        >
                            <Button
                                style="margin-top: 10px"
                                @click="connexion"
                                :disabled="
                                    !booleanControlEmail || password.length == 0
                                "
                                >Se connecter</Button
                            >
                        </CardFooter>
                    </Card>
                </TabsContent>
                <TabsContent value="password">
                    <Card>
                        <CardHeader>
                            <CardTitle>Inscription</CardTitle>
                            <CardDescription
                                v-if="textControlInscription == null"
                            >
                                Inscrivez-vous et rejoigner plus de 1500
                                apprenants.
                            </CardDescription>
                            <CardDescription v-else>
                                <Alert variant="destructive" class="mt-4">
                                    <AlertCircle class="w-4 h-4" />
                                    <AlertTitle>Oup's ...</AlertTitle>
                                    <AlertDescription>
                                        {{ textControlInscription }}
                                    </AlertDescription>
                                </Alert>
                            </CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-2">
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
                                        @blur="controlValidEmail(email)"
                                    />
                                </section>
                            </div>

                            <CardDescription
                                style="margin-left: 3px; margin-top: 5px"
                            >
                                {{ textControlEmail }}
                            </CardDescription>
                            <br />
                            <div class="flex-center">
                                <section class="section-password">
                                    <Input
                                        :type="
                                            passwordVisible
                                                ? 'text'
                                                : 'password'
                                        "
                                        v-model="password"
                                        placeholder="Mot de passe"
                                        style="margin-right: 10px"
                                        @input="
                                            controlPassword(
                                                password,
                                                controlConfirmPassword
                                            )
                                        "
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
                                            <path
                                                d="M14.084 14.158a3 3 0 0 1-4.242-4.242"
                                            />
                                            <path
                                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"
                                            />
                                            <path d="m2 2 20 20" />
                                        </svg>
                                    </span>
                                </section>
                            </div>

                            <CardDescription
                                style="margin-left: 3px; margin-top: 5px"
                            >
                                {{ textControlPassword }}
                            </CardDescription>

                            <br />
                            <div class="flex-center">
                                <section class="section-password">
                                    <Input
                                        :type="
                                            confirmPasswordVisible
                                                ? 'text'
                                                : 'password'
                                        "
                                        v-model="confirmPassword"
                                        placeholder="Confirmer le mot de passe"
                                        style="margin-right: 10px"
                                        @input="
                                            controlConfirmPassword(
                                                confirmPassword
                                            )
                                        "
                                        :disabled="!booleanControlPassword"
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
                                            <path
                                                d="M14.084 14.158a3 3 0 0 1-4.242-4.242"
                                            />
                                            <path
                                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"
                                            />
                                            <path d="m2 2 20 20" />
                                        </svg>
                                    </span>
                                </section>
                            </div>

                            <CardDescription
                                style="margin-left: 3px; margin-top: 5px"
                            >
                                {{ textControlConfirmPassword }}
                            </CardDescription>
                        </CardContent>
                        <CardFooter
                            style="display: flex; justify-content: center"
                        >
                            <Button
                                style="margin-top: 10px"
                                @click="inscription"
                                :disabled="
                                    !booleanControlPassword ||
                                    !booleanControlConfirmPassword ||
                                    !booleanControlEmail
                                "
                                >S'inscrire</Button
                            >
                        </CardFooter>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
        <!-- fin refonte avec TABS -->
    </div>
</template>

<script>
import axios from "axios";
import { Input } from "../../../src/components/ui/input";
import { Label } from "../../../src/components/ui/label";
import { Button } from "../../../src/components/ui/button";
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from "../../../src/components/ui/tabs";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "../../../src/components/ui/card";

import {
    Alert,
    AlertDescription,
    AlertTitle,
} from "../../../src/components/ui/alert";

import { AlertCircle } from "lucide-vue-next";

export default {
    name: "AuthentificationPage",
    components: {
        Label,
        Input,
        Button,
        Tabs,
        TabsContent,
        TabsList,
        TabsTrigger,
        Card,
        CardHeader,
        CardTitle,
        CardDescription,
        CardContent,
        CardFooter,
        Alert,
        AlertDescription,
        AlertTitle,
        AlertCircle,
    },
    data() {
        return {
            password: "",
            confirmPassword: "",
            email: "",
            isAuthenticated:
                (localStorage.getItem("isUser") ||
                    localStorage.getItem("isClient") ||
                    localStorage.getItem("isAdmin")) === "true",
            passwordVisible: false,
            confirmPasswordVisible: false,
            showRegister: false,
            textControlPassword:
                "Votre mot de passe doit contenir au moins 8 caractères, une minuscule, une majuscule, un chiffre.",
            booleanControlPassword: false,
            booleanControlConfirmPassword: false,
            textControlConfirmPassword: "",
            booleanControlEmail: null,
            textControlEmail: "",
            textControlConnexion: null,
            textControlInscription: null,
        };
    },
    methods: {
        inscription() {
            axios
                .post("/inscription", {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    console.log(response.data.message);

                    if (response.data.message === "Inscription réussie.") {
                        this.getRole(response.data.role);
                    }
                })
                .catch((error) => {
                    if (error.response) {
                        this.textControlInscription =
                            error.response.data.message;
                    } else {
                        this.textControlInscription =
                            "Une erreur s'est produite.";
                    }

                    this.textControlInscription += " 😔";
                });
        },
        getRole(role) {
            this.isAuthenticated = true;

            //isUser, isClient, isAdmin, en fonction du role
            const rolesMap = {
                ROLE_USER: "isUser",
                ROLE_CLIENT: "isClient",
                ROLE_ADMIN: "isAdmin",
            };

            const roleKey = role.includes("ROLE_ADMIN")
                ? "isAdmin"
                : role.includes("ROLE_CLIENT")
                ? "isClient"
                : "isUser";
            localStorage.setItem(roleKey, "true");

            localStorage.setItem("email", this.email);

            // redirection selon le role de l'user
            // si client ou user, on redirge sur /articles
            // si admin, on redirige sur /admin

            const routeName = role.includes("ROLE_ADMIN")
                ? "admin"
                : "articles";
            this.$router.push({ name: routeName });
        },
        connexion() {
            axios
                .get("/connexion", {
                    params: { email: this.email, password: this.password },
                })
                .then((response) => {
                    if (response.data.message === "Authentification réussie.") {
                        this.getRole(response.data.role);
                    }

                    this.textControlConnexion = response.data.message;
                })
                .catch((error) => {
                    if (error.response) {
                        this.textControlConnexion = error.response.data.message;
                    } else {
                        this.textControlConnexion =
                            "Une erreur s'est produite.";
                    }

                    this.textControlConnexion += " 😔";
                });
        },
        togglePasswordVisible() {
            this.passwordVisible = !this.passwordVisible;
        },
        toggleConfirmPasswordVisible() {
            this.confirmPasswordVisible = !this.confirmPasswordVisible;
        },
        controlPassword(password, controlConfirmPassword) {
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

            this.controlConfirmPassword(controlConfirmPassword);
        },
        controlConfirmPassword(controlConfirmPassword) {
            if (controlConfirmPassword == this.password) {
                this.textControlConfirmPassword =
                    "Super, vos mots de passe correspondent bien.";
                this.booleanControlConfirmPassword = true;
            } else {
                this.textControlConfirmPassword =
                    "Vos mots de passe ne correspondent pas.";
                this.booleanControlConfirmPassword = false;
            }
        },
        controlValidEmail(email) {
            const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            let result = regex.test(email);

            this.booleanControlEmail = result;

            if (!this.booleanControlEmail) {
                this.textControlEmail =
                    "Attention, votre adresse électronique n'est pas valide.";
            } else {
                this.textControlEmail =
                    "Parfait, votre adresse électronique est valide.";
            }
        },
    },
};
</script>

<style scoped>
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
