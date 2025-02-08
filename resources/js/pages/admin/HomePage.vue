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
            <input
                type="password"
                v-model="password"
                placeholder="Entrez le mot de passe"
            />
            <button @click="checkPassword">Valider</button>
            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            password: "",
            isAuthenticated: localStorage.getItem("isAdmin") === "true",
            errorMessage: "",
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
    },
};
</script>

<style scoped>
.error {
    color: red;
    margin-top: 10px;
}
</style>
