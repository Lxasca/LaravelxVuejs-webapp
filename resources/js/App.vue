<template>
    <div
        style="
            /**box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);**/
            padding: 25px;
            color: #262626;

            padding-bottom: 50px;
            padding-left: 90px;
            padding-right: 100px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        "
    >
        <section
            style="display: flex; justify-content: center; align-items: center"
        >
            <router-link style="margin-right: 40px" to="/">Accueil</router-link>
            <router-link to="/articles" style="margin-right: 20px">
                <Button class="btn-duo-main"
                    >Commencer à apprendre l'arabe
                </Button>
            </router-link>
            <span style="display: flex; align-items: center"
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-move-left"
                >
                    <path d="M6 8L2 12L6 16" />
                    <path d="M2 12H22" /></svg
                ><span style="margin-left: 15px; margin-top: -1.5px"
                    >gratuitement et sans inscription</span
                ></span
            >
        </section>

        <section
            style="display: flex; justify-content: center; align-items: center"
        >
            <DropdownMenu>
                <DropdownMenuTrigger as-child style="margin-right: 40px">
                    <Button variant="outline"> Configuration </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-56">
                    <DropdownMenuGroup>
                        <DropdownMenuItem>
                            Customiser la couleur
                            <Input
                                type="color"
                                v-model="selectedColor"
                                @input="updateMainColor"
                                @click.stop
                                style="width: 50px"
                            />
                        </DropdownMenuItem>
                    </DropdownMenuGroup>
                </DropdownMenuContent>
            </DropdownMenu>

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

    <div>
        <router-view></router-view>
    </div>
</template>

<script>
import { Input } from "../../src/components/ui/input";
import { Button } from "../../src/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "../../src/components/ui/dropdown-menu";

export default {
    name: "App",
    components: {
        Input,
        Button,
        DropdownMenu,
        DropdownMenuContent,
        DropdownMenuGroup,
        DropdownMenuItem,
        DropdownMenuTrigger,
    },
    data() {
        return {
            selectedColor: "#ffc300",
        };
    },
    methods: {
        updateMainColor() {
            document.documentElement.style.setProperty(
                "--main-color",
                this.selectedColor
            );
        },
    },
    mounted() {
        this.updateMainColor(); // Met à jour la couleur au chargement
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
    border: solid 2px #f8da61;

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
    border: solid 2px #f8da61;
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
    color: #ffc300;
}
</style>
