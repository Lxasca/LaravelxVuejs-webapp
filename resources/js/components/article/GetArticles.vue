<template>
    <section>
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
                            <Button v-if="article.category">{{
                                article.category.name
                            }}</Button>
                        </TableCell>
                        <TableCell style="width: 10%; text-align: center">
                            <Button v-if="article.level" variant="secondary">
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
                                                                formEdit(
                                                                    article
                                                                )
                                                            "
                                                            >Editer</span
                                                        >
                                                    </DropdownMenuItem>
                                                    <DropdownMenuItem>
                                                        <span
                                                            @click="
                                                                formDelete(
                                                                    article
                                                                )
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
                                                                        'unpublished' ||
                                                                    article.status ==
                                                                        null
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
                    <Card class="shadow border-input rounded-md">
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
                                <!--<Switch />-->
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
                                        line-height: 45px;
                                    "
                                    >{{ article.title }}</CardTitle
                                >
                                <CardDescription
                                    style="
                                        font-size: 17.5px;
                                        margin-top: -5px;
                                        margin-left: 2px;
                                        color: black;
                                    "
                                >
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
                                <Button v-if="article.category">{{
                                    article.category.name
                                }}</Button>
                                <Button
                                    v-if="article.level"
                                    variant="secondary"
                                    style="margin-left: 12.5px"
                                >
                                    {{ article.level.name }}
                                </Button>
                            </CardContent>
                        </router-link>
                    </Card>
                </div>
            </div>
        </div>
    </section>
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

import JSZip from "jszip";
import { saveAs } from "file-saver";

export default {
    name: "GetArticles",
    data() {
        return {
            article: [],
        };
    },
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
            const articleId = article.id;
            const zip = new JSZip();

            axios
                .get(`/get-article/${articleId}`)
                .then((response) => {
                    this.article = response.data;

                    const title_arabic = this.article.title;
                    const title_french = this.article.title_french;

                    const imageUrl = new URL(
                        "../../../images/cm.png",
                        import.meta.url
                    ).href;
                    fetch(imageUrl)
                        .then((res) => res.blob())
                        .then((blob) => {
                            const img = new Image();
                            img.onload = () => {
                                const canvas = document.createElement("canvas");
                                const ctx = canvas.getContext("2d");
                                canvas.width = img.width;
                                canvas.height = img.height;
                                ctx.drawImage(img, 0, 0);

                                ctx.font = "250px 'Roboto Condensed'";
                                ctx.fillStyle = "black";
                                title_arabic
                                    .split(/(.{1,20})(\s|$)/g)
                                    .filter(Boolean)
                                    .forEach((line, i) =>
                                        ctx.fillText(
                                            line.trim(),
                                            (canvas.width -
                                                ctx.measureText(line.trim())
                                                    .width) /
                                                2,
                                            1600 + i * 125
                                        )
                                    );

                                ctx.font = "100px 'Roboto Condensed'";
                                ctx.fillStyle = "black";
                                title_french
                                    .split(/(.{1,50})(\s|$)/g)
                                    .filter(Boolean)
                                    .forEach((line, i) =>
                                        ctx.fillText(
                                            line.trim(),
                                            (canvas.width -
                                                ctx.measureText(line.trim())
                                                    .width) /
                                                2,
                                            1175 + i * 50
                                        )
                                    );

                                canvas.toBlob((canvasBlob) => {
                                    zip.file("minia_1.png", canvasBlob);

                                    axios
                                        .get("/get-vocabularies")
                                        .then((res) => {
                                            const vocabulaires = res.data.map(
                                                (v) => ({
                                                    value: v.value,
                                                    label: v.label,
                                                    phonetique: v.phonetique,
                                                    id: v.id,
                                                    day: v.day,
                                                })
                                            );

                                            const imageUrl2 = new URL(
                                                "../../../images/cm2.png",
                                                import.meta.url
                                            ).href;

                                            fetch(imageUrl2)
                                                .then((res) => res.blob())
                                                .then((blob2) => {
                                                    const img2 = new Image();
                                                    img2.onload = () => {
                                                        let remaining =
                                                            vocabulaires.length;

                                                        vocabulaires.forEach(
                                                            (vocab) => {
                                                                const canvas2 =
                                                                    document.createElement(
                                                                        "canvas"
                                                                    );
                                                                const ctx2 =
                                                                    canvas2.getContext(
                                                                        "2d"
                                                                    );
                                                                canvas2.width =
                                                                    img2.width;
                                                                canvas2.height =
                                                                    img2.height;

                                                                ctx2.drawImage(
                                                                    img2,
                                                                    0,
                                                                    0
                                                                );

                                                                ctx2.font =
                                                                    "100px 'Roboto Condensed'";
                                                                ctx2.fillStyle =
                                                                    "#58ca60";
                                                                const text4 = `${vocab.day}`;
                                                                const textWidth4 =
                                                                    ctx2.measureText(
                                                                        text4
                                                                    ).width;
                                                                const x4 =
                                                                    canvas2.width /
                                                                        2 -
                                                                    textWidth4 /
                                                                        2 -
                                                                    8;
                                                                const y4 =
                                                                    canvas2.height -
                                                                    1190;
                                                                ctx2.fillText(
                                                                    text4,
                                                                    x4,
                                                                    y4
                                                                );

                                                                ctx2.font =
                                                                    "bold 260px 'Roboto Condensed'";
                                                                ctx2.fillStyle =
                                                                    "#58ca60";
                                                                const text2 = `${vocab.label}`;
                                                                const textWidth2 =
                                                                    ctx2.measureText(
                                                                        text2
                                                                    ).width;
                                                                const x2 =
                                                                    canvas2.width /
                                                                        2 -
                                                                    textWidth2 /
                                                                        2;
                                                                const y2 =
                                                                    canvas2.height -
                                                                    550;
                                                                ctx2.fillText(
                                                                    text2,
                                                                    x2,
                                                                    y2
                                                                );

                                                                ctx2.font =
                                                                    "italic 75px 'Roboto Condensed'";
                                                                ctx2.fillStyle =
                                                                    "black";
                                                                const text3 = `${vocab.phonetique}`;
                                                                const textWidth3 =
                                                                    ctx2.measureText(
                                                                        text3
                                                                    ).width;
                                                                const x3 =
                                                                    canvas2.width /
                                                                        2 -
                                                                    textWidth3 /
                                                                        2;
                                                                const y3 =
                                                                    canvas2.height -
                                                                    425;
                                                                ctx2.fillText(
                                                                    text3,
                                                                    x3,
                                                                    y3
                                                                );

                                                                ctx2.font =
                                                                    "bold 100px 'Roboto Condensed'";
                                                                ctx2.fillStyle =
                                                                    "black";
                                                                const text = `${vocab.value}`;
                                                                const textWidth =
                                                                    ctx2.measureText(
                                                                        text
                                                                    ).width;
                                                                const x =
                                                                    canvas2.width /
                                                                        2 -
                                                                    textWidth /
                                                                        2;
                                                                const y =
                                                                    canvas2.height -
                                                                    290;
                                                                ctx2.fillText(
                                                                    text,
                                                                    x,
                                                                    y
                                                                );

                                                                canvas2.toBlob(
                                                                    (
                                                                        canvasBlob2
                                                                    ) => {
                                                                        zip.file(
                                                                            `minia_vocab_${vocab.value}.png`,
                                                                            canvasBlob2
                                                                        );
                                                                        remaining--;
                                                                        if (
                                                                            remaining ===
                                                                            0
                                                                        ) {
                                                                            zip.generateAsync(
                                                                                {
                                                                                    type: "blob",
                                                                                }
                                                                            ).then(
                                                                                (
                                                                                    zipBlob
                                                                                ) => {
                                                                                    saveAs(
                                                                                        zipBlob,
                                                                                        "pack_CM_" +
                                                                                            title_french +
                                                                                            ".zip"
                                                                                    );
                                                                                }
                                                                            );
                                                                        }
                                                                    }
                                                                );
                                                            }
                                                        );
                                                    };
                                                    img2.src =
                                                        URL.createObjectURL(
                                                            blob2
                                                        );
                                                });
                                        });
                                });
                            };
                            img.src = URL.createObjectURL(blob);
                        });
                })
                .catch((error) => {
                    console.log("erreur : ", error);
                });
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
    gap: 35px;
    margin-left: 2.5%;
    margin-right: 2.5%;
}

@media (max-width: 1000px) {
    .card-grid {
        display: block;
        margin-left: 2%;
        margin-right: 2.75%;
    }

    .card-grid > * {
        display: block;
        width: 100%;
        margin-bottom: 20px;
    }
}
</style>
