<template>
    <div class="div-content">
        <Table style="background-color:red;">
            <TableCaption>A list of your recent invoices.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]"> Invoice </TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Method</TableHead>
                    <TableHead class="text-right"> Amount </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow>
                    <TableCell class="font-medium"> INV001 </TableCell>
                    <TableCell>Paid</TableCell>
                    <TableCell>Credit Card</TableCell>
                    <TableCell class="text-right"> $250.00 </TableCell>
                </TableRow>
            </TableBody>
        </Table>

        <div v-for="article in articles" :key="article.id">
            <section id="div-content-section">
                <!-- si is Admin -->
                <div v-if="isAdmin" style="margin-top: -10px">
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="outline"> ... </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent class="w-56">
                            <DropdownMenuGroup>
                                <DropdownMenuSub>
                                    <DropdownMenuSubTrigger>
                                        <span>Actions</span>
                                    </DropdownMenuSubTrigger>
                                    <DropdownMenuPortal>
                                        <DropdownMenuSubContent>
                                            <DropdownMenuItem>
                                                <span @click="formEdit(article)"
                                                    >Editer</span
                                                >
                                            </DropdownMenuItem>
                                            <DropdownMenuItem>
                                                <span
                                                    @click="formDelete(article)"
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
                </div>

                <Button class="button-createdAt btn-0" style="margin-top: 5px">
                    {{
                        new Date(article.created_at).toLocaleDateString("fr-FR")
                    }}
                </Button>

                <h5>
                    <router-link
                        :to="{
                            name: 'article',
                            params: { article_id: article.id },
                        }"
                        style="text-decoration: none; color: black"
                    >
                        <span v-if="!article.isSwitched">{{
                            article.title
                        }}</span>
                        <span id="title-french" v-else>
                            {{ article.title_french }}
                        </span>
                    </router-link>
                </h5>
            </section>
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
