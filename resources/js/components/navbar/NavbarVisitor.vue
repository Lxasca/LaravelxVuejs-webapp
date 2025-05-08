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
    name: "NavbarVisitor",
    components: {
        DropdownMenu,
        DropdownMenuContent,
        DropdownMenuGroup,
        DropdownMenuItem,
        DropdownMenuTrigger,
    },
};
</script>

<style scoped></style>
