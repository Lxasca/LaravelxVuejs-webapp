import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import ArticlesPage from "./pages/ArticlesPage.vue";
import ArticlePage from "./pages/ArticlePage.vue";
import ExercicePage from "./pages/exercice/ExercicePage.vue";
import HomePageAdmin from "./pages/admin/HomePage.vue";
import ArticlesPageAdmin from "./pages/admin/ArticlesPage.vue";
import AccountPage from "./pages/auth/AccountPage.vue";
import AuthentificationPage from "./pages/auth/AuthentificationPage.vue";
import MentionsPage from "./pages/footer/MentionsPage.vue";
import PolitiquePage from "./pages/footer/PolitiquePage.vue";

// isUser, isClient, isAdmin
const requireAdminAuth = (to, from, next) => {
    if (localStorage.getItem("isAdmin")) {
        next();
    } else {
        next({ name: "home" });
    }
};

const requireAuth = (to, from, next) => {
    if (
        localStorage.getItem("isAdmin") ||
        localStorage.getItem("isClient") ||
        localStorage.getItem("isUser")
    ) {
        next();
    } else {
        next({ name: "authentification" });
    }
};

const requireNoAuth = (to, from, next) => {
    if (
        localStorage.getItem("isAdmin") ||
        localStorage.getItem("isClient") ||
        localStorage.getItem("isUser")
    ) {
        // si déjà connecté, il peut pas accéder aux pages d'auth, on le renvoie sur son compte
        next({ name: "account" });
    } else {
        next();
    }
};

const routes = [
    { path: "/mentions-legales", name: "mentions", component: MentionsPage },
    ,
    {
        path: "/politique-de-confidentialité",
        name: "politique",
        component: PolitiquePage,
    },
    ,
    { path: "/", name: "home", component: HomePage },
    // lecture - compréhension écrite : artiles
    {
        name: "articles",
        path: "/articles",
        component: ArticlesPage,
    },
    {
        name: "article",
        path: "/article/:article_id",
        component: ArticlePage,
    },
    // exercice - article
    {
        name: "exercice",
        path: "/article/:article_id/exercice/quizz",
        component: ExercicePage,
    },
    // AUTH
    {
        name: "authentification",
        path: "/authentification",
        component: AuthentificationPage,
        beforeEnter: requireNoAuth,
    },
    // ADMIN
    {
        name: "admin",
        path: "/admin",
        component: HomePageAdmin,
        beforeEnter: requireAdminAuth,
    },
    {
        name: "admin-articles",
        path: "/admin/articles",
        component: ArticlesPageAdmin,
        beforeEnter: requireAdminAuth,
    },
    {
        name: "account",
        path: "/mon-compte",
        component: AccountPage,
        beforeEnter: requireAuth,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount("#app");
