<template>
    <div class="div-content" v-if="isAdmin">
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
                        >Titre</TableHead
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
                        <Button
                            :variant="
                                formatDate(article.created_at) ===
                                'Aujourd\'hui'
                                    ? 'secondary'
                                    : 'outline'
                            "
                        >
                            <span
                                v-if="
                                    formatDate(article.created_at) ===
                                    'Aujourd\'hui'
                                "
                                >Aujourd'hui</span
                            >
                            <span v-else>
                                {{
                                    new Date(
                                        article.created_at
                                    ).toLocaleDateString("fr-FR")
                                }}
                            </span>
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
    <div v-else>
        <div class="card-grid">
            <div v-for="article in articles" :key="article.id">
                <Card>
                    <CardHeader>
                        <CardDescription
                            style="
                                align-items: center;
                                display: flex;
                                justify-content: space-between;
                            "
                        >
                            <Button
                                :variant="
                                    formatDate(article.created_at) ===
                                    'Aujourd\'hui'
                                        ? 'secondary'
                                        : 'outline'
                                "
                            >
                                <span
                                    v-if="
                                        formatDate(article.created_at) ===
                                        'Aujourd\'hui'
                                    "
                                    >Aujourd'hui</span
                                >
                                <span v-else>
                                    {{
                                        new Date(
                                            article.created_at
                                        ).toLocaleDateString("fr-FR")
                                    }}
                                </span>
                            </Button>
                            <Switch />
                        </CardDescription>

                        <router-link
                            :to="{
                                name: 'article',
                                params: { article_id: article.id },
                            }"
                        >
                            <CardTitle
                                style="
                                    direction: rtl;
                                    margin-top: 15px;
                                    margin-bottom: 10px;
                                    font-weight: normal;
                                    font-size: 30px;
                                "
                                >{{ article.title }}</CardTitle
                            >
                            <CardDescription style="font-size: 15px">
                                {{ article.title_french }}
                            </CardDescription>
                        </router-link>
                    </CardHeader>

                    <router-link
                        :to="{
                            name: 'article',
                            params: { article_id: article.id },
                        }"
                    >
                        <CardContent>
                            <Button> Relations internationales </Button>
                            <Button
                                variant="secondary"
                                style="margin-left: 12.5px"
                            >
                                Débutant
                            </Button>

                            <!--<div
                                class="flex items-center space-x-4 rounded-md border px-4"
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    margin-top: 25px;
                                    padding-top: 11.5px;
                                    padding-bottom: 10px;
                                "
                            >
                                <section>
                                    <p style="font-size: 15px">
                                        Lorem, ipsum dolor sit amet consectetur
                                        adipisicing elit. A ipsum magnam nulla
                                        fuga beatae odit mollitia itaque.
                                        Aliquam accusantium impedit qui
                                        consequuntur aut enim id nisi.
                                    </p>
                                </section>
                            </div>-->
                        </CardContent>
                    </router-link>
                </Card>
            </div>
        </div>
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
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "../../../../src/components/ui/card";
import { Switch } from "../../../../src/components/ui/switch";
import { cn } from "../../../../src/lib/utils";
import { BellIcon, CheckIcon } from "@radix-icons/vue";
import { Badge } from "../../../../src/components/ui/badge";

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
        Card,
        CardContent,
        CardDescription,
        CardFooter,
        CardHeader,
        CardTitle,
        Switch,
        cn,
        BellIcon,
        CheckIcon,
        Badge,
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
        formatDate(dateString) {
            const date = new Date(dateString);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            if (date.toDateString() === today.toDateString()) {
                return "Aujourd'hui";
            } else {
                return date.toLocaleDateString("fr-FR");
            }
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

.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}
</style>
