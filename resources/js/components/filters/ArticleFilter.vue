<template>
    <div>
        <div class="responsive-container">
            <section>
                <Select v-model="sortOrder">
                    <SelectTrigger style="width: 315px">
                        <SelectValue placeholder="Trier par date" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="asc">
                                Du plus ancien au plus récent
                            </SelectItem>
                            <SelectItem value="desc">
                                Du plus récent au plus ancien
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </section>
            <!-- Champs de sélection des levels -->
            <section>
                <Combobox
                    by="label"
                    v-model="selectedLevelName"
                    @update:modelValue="handleSelectionLevel"
                    style="margin-right: 5px"
                >
                    <ComboboxAnchor as-child style="width: 147px">
                        <ComboboxTrigger as-child>
                            <Button variant="outline" class="justify-between">
                                {{ selectedLevelName || "Niveau" }}

                                <ChevronsUpDown
                                    class="ml-2 h-4 w-4 shrink-0 opacity-50"
                                />
                            </Button>
                        </ComboboxTrigger>
                    </ComboboxAnchor>

                    <ComboboxList>
                        <div class="relative w-full max-w-sm items-center">
                            <ComboboxInput
                                class="pl-9 focus-visible:ring-0 border-0 border-b rounded-none h-10"
                                placeholder="Rechercher ..."
                            />
                        </div>

                        <ComboboxEmpty> Aucun résultat. </ComboboxEmpty>

                        <ComboboxGroup>
                            <ComboboxItem
                                v-for="level in levels"
                                :key="level.id"
                                :value="level.name"
                            >
                                <div style="font-size: 16px">
                                    {{ level.name }}
                                </div>

                                <ComboboxItemIndicator>
                                    <Check class="ml-auto h-4 w-4" />
                                </ComboboxItemIndicator>
                            </ComboboxItem>

                            <ComboboxItem
                                :value="null"
                                v-if="selectedLevelName"
                                style="background-color: hsl(var(--secondary))"
                            >
                                <div style="font-size: 16px">
                                    Supprimer le filtre
                                </div>
                            </ComboboxItem>
                        </ComboboxGroup>
                    </ComboboxList>
                </Combobox>
            </section>
            <!-- Champs de sélection des categories -->
            <section>
                <Combobox
                    by="label"
                    v-model="selectedCategoryName"
                    @update:modelValue="handleSelectionCategory"
                    style="margin-right: 5px"
                >
                    <ComboboxAnchor as-child>
                        <ComboboxTrigger as-child style="width: 147px">
                            <Button variant="outline" class="justify-between">
                                {{ selectedCategoryName ?? "Catégorie" }}

                                <ChevronsUpDown
                                    class="ml-2 h-4 w-4 shrink-0 opacity-50"
                                />
                            </Button>
                        </ComboboxTrigger>
                    </ComboboxAnchor>

                    <ComboboxList>
                        <div class="relative w-full max-w-sm items-center">
                            <ComboboxInput
                                class="pl-9 focus-visible:ring-0 border-0 border-b rounded-none h-10"
                                placeholder="Rechercher ..."
                            />
                        </div>

                        <ComboboxEmpty> Aucun résultat. </ComboboxEmpty>

                        <ComboboxGroup>
                            <ComboboxItem
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.name"
                            >
                                <div style="font-size: 16px">
                                    {{ category.name }}
                                </div>

                                <ComboboxItemIndicator>
                                    <Check class="ml-auto h-4 w-4" />
                                </ComboboxItemIndicator>
                            </ComboboxItem>

                            <ComboboxItem
                                :value="null"
                                v-if="selectedCategoryName"
                                style="background-color: hsl(var(--secondary))"
                            >
                                <div style="font-size: 16px">
                                    Supprimer le filtre
                                </div>
                            </ComboboxItem>
                        </ComboboxGroup>
                    </ComboboxList>
                </Combobox>
            </section>
        </div>
    </div>
</template>

<script>
import axios from "axios";

import { Button } from "../../../../src/components/ui/button";

import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "../../../../src/components/ui/select";

import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger,
} from "../../../../src/components/ui/combobox";

import { Check, ChevronsUpDown, Search } from "lucide-vue-next";

export default {
    name: "ArticleFilter",
    components: {
        Select,
        SelectContent,
        SelectGroup,
        SelectItem,
        SelectLabel,
        SelectTrigger,
        SelectValue,
        //
        Combobox,
        ComboboxAnchor,
        ComboboxEmpty,
        ComboboxGroup,
        ComboboxInput,
        ComboboxItem,
        ComboboxItemIndicator,
        ComboboxList,
        ComboboxTrigger,
        //
        Button,
        //
        Check,
        ChevronsUpDown,
        Search,
    },
    data() {
        return {
            selectedLevelName: "",
            selectedCategoryName: null,
            sortOrder: "desc",
            levels: {},
            categories: {},
        };
    },
    mounted() {
        this.getLevels();
        this.getCategories();
    },
    watch: {
        // lorsque sortOrder change, on relance le tri
        sortOrder() {
            this.getArticles();
        },
        selectedLevelName() {
            this.getArticles();
        },
        selectedCategoryName() {
            this.getArticles();
        },
    },
    methods: {
        getLevels() {
            axios.get("/get-levels").then((response) => {
                this.levels = response.data;
            });
        },
        handleSelectionLevel(selected) {
            this.selectedLevelName = selected;
        },
        handleSelectionCategory(selected) {
            this.selectedCategoryName = selected;
        },
        getCategories() {
            axios.get(`/get-categories`).then((response) => {
                this.categories = response.data;
            });
        },
        //
        getArticles() {
            this.$emit("update:filters", {
                sortOrder: this.sortOrder,
                level: this.selectedLevelName,
                category: this.selectedCategoryName,
            });
        },
    },
};
</script>
<style scoped>
.responsive-container {
    display: flex;
    gap: 15px;
}

@media (max-width: 767px) {
    .responsive-container {
        flex-wrap: wrap;
        padding-left: 20px;
    }
}
</style>
