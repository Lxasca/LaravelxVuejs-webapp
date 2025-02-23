<template>
    <div
        style="
            /**box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);**/
            padding: 25px;
            background-color: white;
            color: #262626;
            margin-left: 4%;
            margin-right: 4%;
            display: flex;
            align-items: center;

            padding-bottom: 50px;
        "
    >
        <Input
            type="color"
            v-model="selectedColor"
            @input="updateMainColor"
            style="width: 50px"
        />

        <router-link to="/articles" style="margin-left: 25px"
            >Consulter tous les articles</router-link
        >
        <router-link to="/admin" style="margin-left: 25px"
            >Accéder à l'espace d'administration</router-link
        >
    </div>

    <div>
        <router-view></router-view>
    </div>
</template>

<script>
import { Input } from "../../src/components/ui/input";

export default {
    name: "App",
    components: { Input },
    data() {
        return {
            selectedColor: "#009f6b",
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
</style>
