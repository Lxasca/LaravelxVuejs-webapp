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
                    class="button-createdAt d-flex-align btn-2"
                    @click="toggleHelp"
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
                        color: item.enabled() ? 'var(--main-color)' : '',
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
        fontSize: Number,
        dropdownIsShow: Boolean,
        isSwitchedContent: Boolean,
        buttonConfig: Array,
    },
    methods: {
        toggleHelp() {
            this.$emit("update:isShowHelp", !this.isShowHelp);
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

<style scoped></style>
