<template>
    <p
        v-if="articlesEmpty !== ''"
        style="margin-left: 37.5px; margin-top: 25px"
    >
        {{ articlesEmpty }}
    </p>
    <div class="div-content" v-if="isAdmin">
        <Table v-if="articlesEmpty == ''" style="margin-top: 35px">
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center" style="width: 5%">
                        <!--Statut-->
                    </TableHead>
                    <TableHead class="text-center" style="width: 15%">
                        Date de création
                    </TableHead>
                    <!--<TableHead class="text-center" style="width: 10%">
                        Par
                    </TableHead>-->
                    <TableHead class="text-center" style="width: 45%"
                        >Titre</TableHead
                    >
                    <TableHead style="width: 10%"> </TableHead>
                    <TableHead style="width: 10%"> </TableHead>
                    <TableHead
                        class="text-center"
                        style="width: 10%"
                    ></TableHead>
                </TableRow>
            </TableHeader>
            <br />
            <TableBody>
                <TableRow v-for="article in articles" :key="article.id">
                    <TableCell style="width: 5%">
                        <span v-if="article.status == 'published'">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="var(--main-color)"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-circle-check-big-icon lucide-circle-check-big"
                            >
                                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                                <path d="m9 11 3 3L22 4" />
                            </svg>
                        </span>
                    </TableCell>
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
                    <!--<TableCell style="width: 10%"> John Doe</TableCell>-->
                    <TableCell style="width: 45%">
                        <span style="font-size: 30px">
                            {{ article.title }}
                        </span>
                    </TableCell>
                    <TableCell style="width: 10%; text-align: center">
                        <Button>{{ article.category.name }}</Button>
                    </TableCell>
                    <TableCell style="width: 10%; text-align: center">
                        <Button variant="secondary">
                            {{ article.level.name }}
                        </Button>
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
                                                    <span
                                                        @click="
                                                            changeStatus(
                                                                article
                                                            )
                                                        "
                                                    >
                                                        <span
                                                            v-if="
                                                                article.status ==
                                                                'unpublished'
                                                            "
                                                            >Publier</span
                                                        >
                                                        <span v-else
                                                            >Dépublier</span
                                                        >
                                                    </span>
                                                </DropdownMenuItem>
                                            </DropdownMenuSubContent>
                                        </DropdownMenuPortal>
                                    </DropdownMenuSub>
                                    <DropdownMenuItem>
                                        <span @click="packCM(article)"
                                            >Pack CM</span
                                        >
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
    <div style="margin-top: 25px" v-else>
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
                            <Button>{{ article.category.name }}</Button>
                            <Button
                                variant="secondary"
                                style="margin-left: 12.5px"
                            >
                                {{ article.level.name }}
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
import axios from "axios";
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
        articlesEmpty: {
            type: String,
            required: false,
        },
    },
    methods: {
        packCM(article) {
            //
            const articleId = article.id;
            console.log("pack cm pour l'article :", articleId);

            const canvas = document.createElement("canvas");
            canvas.width = 1080;
            canvas.height = 1080;

            const ctx = canvas.getContext("2d");
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = url;
                link.download = `pack_cm_${article.id}.png`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            }, "image/png");
        },
        formEdit(article) {
            this.$emit("is-form-edit", article);
        },
        formDelete(article) {
            this.$emit("form-delete", article.id);
        },
        changeStatus(article) {
            // Passe le champ status de 'published' / 'unpublished'

            axios
                .put(`/admin/update-status-article/${article.id}`)
                .then((response) => {
                    article.status =
                        article.status === "published"
                            ? "unpublished"
                            : "published";
                })
                .catch((error) => {
                    console.error(
                        "Error changement status de l'article",
                        error
                    );
                });
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

    margin-top: 15px;
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
    gap: 75px;
    margin-left: 0.9%;
    margin-right: 0.9%;
}
</style>
