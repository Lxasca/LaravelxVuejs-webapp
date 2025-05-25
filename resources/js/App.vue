<template>
    <div>
        <!-- si connecté & admin -->
        <navbar-admin v-if="isAdminBoolean"></navbar-admin>
        <!-- si connecté & client -->
        <navbar-client v-else-if="isClientBoolean"></navbar-client>
        <!-- si connecté mais pas client -->
        <navbar-user v-else-if="isUserBoolean"></navbar-user>
        <!-- si pas connecté (visiteur) -->
        <navbar-visitor v-else></navbar-visitor>
    </div>

    <div>
        <router-view></router-view>
    </div>

    <div id="footer">
        <router-link :to="{ name: 'mentions' }" class="footer-item"
            >Mentions légales</router-link
        >

        <router-link :to="{ name: 'politique' }" class="footer-item"
            >Po. de confidentialité</router-link
        >

        <a
            class="footer-item"
            href="https://www.instagram.com/kaly.mz"
            target="_BLANK"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="19"
                height="19"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide lucide-instagram-icon lucide-instagram"
            >
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
            </svg>
        </a>
    </div>
</template>

<script>
import { Input } from "../../src/components/ui/input";
import { Button } from "../../src/components/ui/button";
import NavbarAdmin from "@/components/navbar/NavbarAdmin.vue";
import NavbarClient from "./components/navbar/NavbarClient.vue";
import NavbarUser from "./components/navbar/NavbarUser.vue";
import NavbarVisitor from "./components/navbar/NavbarVisitor.vue";

export default {
    name: "App",
    components: {
        Input,
        Button,
        NavbarAdmin,
        NavbarClient,
        NavbarUser,
        NavbarVisitor,
    },
    data() {
        return {
            selectedColor: "#58ca60",
            isAdminBoolean: false,
            isClientBoolean: false,
            isUserBoolean: false,
        };
    },
    mounted() {
        this.isAdmin();
        this.isClient();
        this.isUser();
        this.updateMainColor(); // Met à jour la couleur au chargement
    },
    methods: {
        isAdmin() {
            if (localStorage.getItem("isAdmin")) {
                this.isAdminBoolean = true;
            }
        },
        isClient() {
            if (localStorage.getItem("isClient")) {
                this.isClientBoolean = true;
            }
        },
        isUser() {
            if (localStorage.getItem("isUser")) {
                this.isUserBoolean = true;
            }
        },
        updateMainColor() {
            document.documentElement.style.setProperty(
                "--main-color",
                this.selectedColor
            );
        },
    },
};
</script>
<style lang="scss">
@import "@/../css/app.css";
@import url("https://fonts.googleapis.com/css2?family=Neucha&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");

:root {
    --main-color: ;
}

* {
    font-family: "Roboto Condensed", serif;
    font-optical-sizing: auto;
    font-style: normal;
    font-weight: normal;
}

.d-flex-center {
    display: flex;
    justify-content: center;
}
.d-flex-evenly {
    display: flex;
    justify-content: space-evenly;
}
.d-flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.d-flex-align {
    display: flex;
    align-items: center;
}
.d-flex-start {
    display: flex;
    justify-content: start;
    align-items: center;
}
.ml-10 {
    margin-left: 10px;
    width: 20px;
}
/**input {
    border: none !important;
    outline: none;
    text-align: center;
    font-size: 22px;
    background-color: transparent;
    color: #ae7cf6;
}
input::placeholder {
    color: #ae7cf6;
}

input:focus {
    box-shadow: none;
}**/

.answer {
    text-align: center;
    padding-top: 25px;

    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    width: 796px;
    height: 50px;
    border-radius: 10px;
    border: solid 2px #58ca60;

    font-size: 22px;
}
.text-color-main {
    color: var(--main-color);
}
.text-color-second {
    color: #fbfbfb;
}

.choice {
    align-items: center;
}

/** pour FirstVocabulary */
div[class^="choice"] input[type="radio"] + span {
    padding: 35px;
    padding-left: 50px;
    padding-right: 50px;

    cursor: pointer;
    border-radius: 10px;

    font-size: 18px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: solid 2px #fbfbfb;
}
div[class^="choice"] input[type="radio"]:checked + span {
    border: solid 2px #58ca60;
}

/** disabled un exercice pour ne pas que l'user puisse changer sa réponse **/
.disabled {
    pointer-events: none;
}

.button-createdAt {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px;
    border-radius: 7.5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
    letter-spacing: 1px;

    cursor: pointer;
}

.btn-0 {
    background-color: #262626;
    color: #fbfbfb;
    border: none;
}

.direction-text-right {
    direction: rtl;
}

.color-style-main {
    color: #58ca60;
}
h1 {
    text-align: center;
    font-size: 70px;
    font-weight: bold;
}
.page-footer {
    padding-left: 5%;
    padding-right: 5%;
    padding-top: 1%;

    h1 {
        padding-bottom: 2.5%;
        color: #58ca60;
    }
}

html,
body {
    height: 100%;
    margin: 0;
}

#app {
    min-height: 100%;
    display: flex;
    flex-direction: column;
}

#footer {
    margin-top: auto;
    padding: 1rem;

    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 14px;

    .footer-item {
        padding-left: 15px;
        padding-right: 15px;
    }
    .footer-item:hover {
        color: #58ca60;
        transition-duration: 0.3s;
    }
}

@media (max-width: 767px) {
    #footer {
        font-size: 12.5px;
    }
}
</style>
