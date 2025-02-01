<template>
    <div id="actions-article">
        <div class="d-flex-between">
            <section class="d-flex-align">
                <button
                    class="button-createdAt d-flex-align btn-1"
                    @click="toggleDropdown"
                >
                    Mettre en forme
                </button>

                <button
                    class="button-createdAt d-flex-align btn-3"
                    @click="toggleHelp"
                    :style="{
                        backgroundColor: isShowHelp ? '#fbfbfb' : '',
                    }"
                >
                    <span>{{
                        isShowHelp
                            ? "Retirer les aides vocabulaires"
                            : "Afficher les aides vocabulaires"
                    }}</span>
                </button>

                <button class="button-createdAt d-flex-align btn-3">
                    <span> Taille de la police </span>
                    <input
                        type="range"
                        :value="fontSize"
                        @input="
                            $emit(
                                'update:fontSize',
                                parseInt($event.target.value)
                            )
                        "
                        min="38"
                        max="60"
                        class="input-policy"
                    />
                </button>
            </section>

            <img
                @click="toggleLanguage"
                src="../../../images/exercises/translate.png"
                width="20px"
                alt="Changer la langue"
                class="pointer"
            />
        </div>

        <div class="d-flex-start" v-if="dropdownIsShow">
            <section class="d-flex-start">
                <button
                    v-for="(item, index) in buttonConfig"
                    :key="index"
                    class="button-selection-words"
                    @click="item.action"
                    :style="{
                        backgroundColor: item.enabled() ? '#fbfbfb' : '',
                    }"
                >
                    {{ item.label }}
                </button>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    name: "ActionsArticle",
    props: {
        isShowHelp: Boolean,
        showTranslation: Boolean,
        fontSize: Number,
        dropdownIsShow: Boolean,
        isSwitchedContent: Boolean,
        buttonConfig: Array,
    },
    methods: {
        toggleHelp() {
            this.$emit("update:isShowHelp", !this.isShowHelp);
            this.$emit("update:showTranslation", false);
        },
        toggleDropdown() {
            this.$emit("update:dropdownIsShow", !this.dropdownIsShow);
        },
        toggleLanguage() {
            this.$emit("update:isSwitchedContent", !this.isSwitchedContent);
        },
    },
};
</script>

<style scoped>
#actions-article {
    border-radius: 7.5px;
    margin: 25px;

    margin-top: -7.5px;
}
.btn-1 {
    background-color: white;
    color: #262626;
    border: none;
}
.btn-2 {
    background-color: var(--main-color);
    color: #fbfbfb;
    border: solid 1px var(--main-color);
    margin-left: 25px;
}
.btn-3 {
    background-color: white;
    color: #262626;
    border: none;
    margin-left: 25px;
    font-size: 13.7px;
}

.button-selection-words {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 7.5px;
    background-color: white;
    border: none;
    color: #262626;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
    letter-spacing: 1px;

    cursor: pointer;

    display: flex;
    align-items: center;

    margin-right: 15px;
    margin-top: 20px;
}
.input-policy {
    color: var(--main-color);
    font-size: 15px;
    width: 60px;

    margin-left: 15px;
}
.pointer {
    cursor: pointer;
}
input[type="range"] {
    -webkit-appearance: none;
}

input[type="range"]::-webkit-slider-runnable-track {
    width: 300px;
    height: 5px;
    background: #ddd;
    border: none;
    border-radius: 3px;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    border: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: var(--main-color);
    margin-top: -5.5px;
}

input[type="range"]:focus {
    outline: none;
}

input[type="range"]:focus::-webkit-slider-runnable-track {
    background: #fbfbfb;
}
</style>
