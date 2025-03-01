<template>
    <div>
        <br />

        <div v-if="isAuthenticated">
            <router-link :to="{ name: 'admin-articles' }"
                >Administration articles</router-link
            >
            <br />

            <router-link to="/mon-compte">Mon compte</router-link>
            <button @click="logout">Déconnexion</button>
        </div>

        <div v-else>
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
                                <CardDescription>
                                    Connectez-vous pour accéder à votre espace
                                    personnel.
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
                                        />
                                    </section>
                                </div>
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
                                    >Se connecter</Button
                                >
                            </CardFooter>
                        </Card>
                    </TabsContent>
                    <TabsContent value="password">
                        <Card>
                            <CardHeader>
                                <CardTitle>Inscription</CardTitle>
                                <CardDescription>
                                    Inscrivez-vous et rejoigner plus de 1500
                                    apprenants.
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
                                        />
                                    </section>
                                </div>
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
                                            @input="controlPassword(password)"
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
                                            @click="
                                                toggleConfirmPasswordVisible
                                            "
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
                                            @click="
                                                toggleConfirmPasswordVisible
                                            "
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
                                        !booleanControlConfirmPassword
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
    </div>
</template>

<script>
import axios from "axios";
import { Input } from "../../../../src/components/ui/input";
import { Button } from "../../../../src/components/ui/button";
import { Label } from "../../../../src/components/ui/label";
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from "../../../../src/components/ui/tabs";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "../../../../src/components/ui/card";

export default {
    components: {
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
    },
    data() {
        return {
            password: "",
            confirmPassword: "",
            email: "",
            isAuthenticated: localStorage.getItem("isAdmin") === "true",
            passwordVisible: false,
            confirmPasswordVisible: false,
            showRegister: false,
            textControlPassword:
                "Votre mot de passe doit contenir au moins 8 caractères, une minuscule, une majuscule, un chiffre.",
            booleanControlPassword: false,
            booleanControlConfirmPassword: false,
            textControlConfirmPassword: "",
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
                        localStorage.setItem("email", this.email);
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
                        localStorage.setItem("email", this.email);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logout() {
            localStorage.removeItem("isAdmin");
            localStorage.removeItem("email");
            this.isAuthenticated = false;
        },
        togglePasswordVisible() {
            this.passwordVisible = !this.passwordVisible;
        },
        toggleConfirmPasswordVisible() {
            this.confirmPasswordVisible = !this.confirmPasswordVisible;
        },
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
            return regex.test(email);
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
