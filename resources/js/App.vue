<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
};
</script>
<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Neucha&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");
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
.ml-10 {
    margin-left: 10px;
    width: 20px;
}

input {
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
}

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
</style>
