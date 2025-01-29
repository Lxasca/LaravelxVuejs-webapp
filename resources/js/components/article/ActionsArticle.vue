<template>
    <div id="actions-article">
        <!-- -->
        <div class="d-flex-between">
            <section class="d-flex-align">
                <button
                    class="button-createdAt d-flex-align btn-1"
                    @click="showDropdown"
                >
                    Mettre en forme
                </button>

                <button
                    class="button-createdAt d-flex-align btn-2"
                    @click="showHelp"
                >
                    <span v-if="isShowHelp">
                        Retirer les aides vocabulaires
                    </span>
                    <span v-else>Afficher les aides vocabulaires</span>
                </button>

                <button class="button-createdAt d-flex-align btn-3">
                    <span> Taille de la police </span>
                    <input
                        type="range"
                        :value="fontSize"
                        @input="$emit('update:fontSize', $event.target.value)"
                        min="38"
                        max="60"
                        class="input-policy"
                    />
                </button>
            </section>

            <img
                @click="changeLanguageContent()"
                src="../../../images/exercises/translate.png"
                width="20px"
                alt=""
                class="pointer"
            />
        </div>
        <div class="d-flex-start">
            <section v-if="dropdownIsShow" class="d-flex-start">
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
        isShowHelp: {
            type: Boolean,
        },
        fontSize: {
            type: Number,
        },
        dropdownIsShow: {
            type: Boolean,
        },
        buttonConfig: {
            type: Array,
        },
    },
    methods: {
        showHelp() {
            //
        },
        showDropdown() {
            //
        },
        changeLanguageContent() {
            //
        },
    },
};
</script>

<style scoped></style>
