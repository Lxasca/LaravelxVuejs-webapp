<template>
    <div>
        <h1>Administration</h1>

        <div v-if="isAuthenticated">
            <router-link :to="{ name: 'admin-articles' }"
                >Administration articles</router-link
            >
            <br />
            <button @click="logout">Déconnexion</button>
        </div>

        <div v-else>
            <div style="display: flex; justify-content: center">
                <section
                    style="width: 400px; align-items: center; display: flex"
                >
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

            <button @click="checkPassword">Valider</button>
            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import { Input } from "../../../../src/components/ui/input";

export default {
    components: { Input },
    data() {
        return {
            password: "",
            isAuthenticated: localStorage.getItem("isAdmin") === "true",
            errorMessage: "",
            passwordVisible: false,
        };
    },
    methods: {
        checkPassword() {
            const adminPassword = "123456";
            if (this.password === adminPassword) {
                localStorage.setItem("isAdmin", "true");
                this.isAuthenticated = true;
            } else {
                this.errorMessage = "Mot de passe incorrect !";
            }
        },
        logout() {
            localStorage.removeItem("isAdmin");
            this.isAuthenticated = false;
        },
        togglePasswordVisible() {
            this.passwordVisible = !this.passwordVisible;
        },
    },
};
</script>

<style scoped>
.error {
    color: red;
    margin-top: 10px;
}
</style>
