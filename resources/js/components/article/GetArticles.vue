<template>
    <div class="div-content">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center" style="width: 15%">
                        Publié le
                    </TableHead>
                    <TableHead class="text-center" style="width: 15%">
                        Par
                    </TableHead>
                    <TableHead class="text-center" style="width: 45%"
                        >Titre de l'article</TableHead
                    >
                    <TableHead class="text-center" style="width: 15%">
                        Catégorie
                    </TableHead>
                    <TableHead
                        class="text-center"
                        style="width: 10%"
                    ></TableHead>
                </TableRow>
            </TableHeader>
            <br />
            <TableBody>
                <TableRow v-for="article in articles" :key="article.id">
                    <TableCell style="width: 15%">
                        <Button variant="outline">
                            {{
                                new Date(article.created_at).toLocaleDateString(
                                    "fr-FR"
                                )
                            }}
                        </Button>
                    </TableCell>
                    <TableCell style="width: 15%">
                        Léa le sang de la veine</TableCell
                    >
                    <TableCell style="width: 45%">
                        <span style="font-size: 30px">
                            {{ article.title }}
                        </span>
                    </TableCell>
                    <TableCell style="width: 15%">
                        <Button>Relations internationales</Button>
                    </TableCell>
                    <TableCell style="width: 10%">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="outline"> ... </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-56">
                                <DropdownMenuGroup>
                                    <DropdownMenuItem>
                                        <router-link
                                            :to="{
                                                name: 'article',
                                                params: {
                                                    article_id: article.id,
                                                },
                                            }"
                                        >
                                            <span>Consulter</span>
                                        </router-link>
                                    </DropdownMenuItem>
                                    <DropdownMenuSub>
                                        <DropdownMenuSubTrigger>
                                            <span>Actions</span>
                                        </DropdownMenuSubTrigger>
                                        <DropdownMenuPortal>
                                            <DropdownMenuSubContent>
                                                <DropdownMenuItem>
                                                    <span
                                                        @click="
                                                            formEdit(article)
                                                        "
                                                        >Editer</span
                                                    >
                                                </DropdownMenuItem>
                                                <DropdownMenuItem>
                                                    <span
                                                        @click="
                                                            formDelete(article)
                                                        "
                                                        >Supprimer</span
                                                    >
                                                </DropdownMenuItem>
                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem>
                                                    <span>More...</span>
                                                </DropdownMenuItem>
                                            </DropdownMenuSubContent>
                                        </DropdownMenuPortal>
                                    </DropdownMenuSub>
                                    <DropdownMenuItem>
                                        <span>New Team</span>
                                        <DropdownMenuShortcut
                                            >⌘+T</DropdownMenuShortcut
                                        >
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

<script>
import { Button } from "../../../../src/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuPortal,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuSubTrigger,
    DropdownMenuTrigger,
} from "../../../../src/components/ui/dropdown-menu";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "../../../../src/components/ui/table";

export default {
    name: "GetArticles",
    components: {
        Button,
        DropdownMenu,
        DropdownMenuContent,
        DropdownMenuGroup,
        DropdownMenuItem,
        DropdownMenuLabel,
        DropdownMenuPortal,
        DropdownMenuSeparator,
        DropdownMenuShortcut,
        DropdownMenuSub,
        DropdownMenuSubContent,
        DropdownMenuSubTrigger,
        DropdownMenuTrigger,
        Table,
        TableBody,
        TableCaption,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
    },
    props: {
        articles: {
            type: Object,
        },
        isAdmin: {
            type: Boolean,
            required: false,
        },
    },
    methods: {
        formEdit(article) {
            this.$emit("is-form-edit", article);
        },
        formDelete(article) {
            this.$emit("form-delete", article.id);
        },
    },
};
</script>

<style scoped>
#div-content-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fbfbfb;

    border-radius: 7.5px;
    padding: 28px;
    padding-top: 5px;
    padding-bottom: 5px;

    height: 80px;

    margin-bottom: 25px;
}

.div-content {
    font-size: 45px;
    line-height: 80px;

    text-align: center;
    padding-left: 2.5%;
    padding-right: 3.5%;
}

h5 {
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 0;
    font-size: 30px;
}

span {
    cursor: pointer;
}
</style>
