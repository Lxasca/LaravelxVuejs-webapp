<template>
    <div
        style="
            padding: 25px;
            color: #262626;

            padding-bottom: 50px;

            display: flex;
            justify-content: center;
            align-items: center;
        "
    >
        <section
            style="display: flex; justify-content: center; align-items: center"
        >
            <router-link style="margin-right: 40px" to="/">Accueil</router-link>

            <router-link style="margin-right: 40px" to="/articles"
                >Articles</router-link
            >

            <router-link to="/admin/articles" style="margin-right: 32.5px">
                <Button> Administration </Button>
            </router-link>
        </section>

        <section
            style="display: flex; justify-content: center; align-items: center"
        >
            <router-link to="/authentification">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-user-round"
                >
                    <circle cx="12" cy="8" r="5" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
            </router-link>

            <button @click="logout" style="margin-left: 20px">
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
        </section>
    </div>
</template>

<script>
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "../../../../src/components/ui/dropdown-menu";

export default {
    name: "NavbarAdmin",
    components: {
        DropdownMenu,
        DropdownMenuContent,
        DropdownMenuGroup,
        DropdownMenuItem,
        DropdownMenuTrigger,
    },
    methods: {
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
