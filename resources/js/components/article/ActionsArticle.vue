<template>
    <div id="actions-article">
        <div>
            <section>
                <TooltipProvider>
                    <Tooltip>
                        <TooltipTrigger>
                            <Button
                                variant="outline"
                                style="margin-right: 10px; margin-top: 10px"
                            >
                                Taille de la police
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
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Agrandir et réduire la taille de la police</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>

                <TooltipProvider>
                    <Tooltip>
                        <TooltipTrigger>
                            <Button
                                @click="toggleHelp"
                                :variant="isShowHelp ? '' : 'outline'"
                                style="margin-right: 10px; margin-top: 10px"
                                >Vocabulaire</Button
                            >
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Afficher l'aide aux vocabulaires</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>

                <TooltipProvider
                    v-for="(item, index) in buttonConfig"
                    :key="index"
                >
                    <Tooltip>
                        <TooltipTrigger>
                            <Button
                                style="margin-right: 10px; margin-top: 10px"
                                @click="item.action"
                                :variant="item.enabled() ? '' : 'outline'"
                                >{{ item.label }}</Button
                            >
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>
                                {{ item.tooltip }}
                            </p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>

                <TooltipProvider>
                    <Tooltip>
                        <TooltipTrigger
                            ><Button
                                @click="toggleLanguage"
                                :variant="isSwitchedContent ? '' : 'outline'"
                                style="margin-right: 10px; margin-top: 10px"
                                alt="Changer la langue"
                            >
                                <p v-if="isSwitchedContent">
                                    Traduction française
                                </p>
                                <p v-else>Traduction française</p></Button
                            ></TooltipTrigger
                        >
                        <TooltipContent>
                            <p v-if="isSwitchedContent">
                                Retirer la traduction
                            </p>
                            <p v-else>Afficher la traduction</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
            </section>
        </div>
    </div>
</template>

<script>
import { Button } from "../../../../src/components/ui/button";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "../../../../src/components/ui/tooltip";

export default {
    name: "ActionsArticle",
    components: {
        Button,
        Tooltip,
        TooltipContent,
        TooltipProvider,
        TooltipTrigger,
    },
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

@media (max-width: 767px) {
    #actions-article {
        margin-top: 50px;

        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        line-height: 10px;
    }

    .section-langue {
        display: flex;
        justify-content: left;
    }
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
