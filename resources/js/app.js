import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import CoursePage from "./pages/CoursePage.vue";
import LevelPage from "./pages/LevelPage.vue";
import StartPage from "./pages/StartPage.vue";
import DictionnaryPage from "./pages/DictionnaryPage.vue";
import ExercisePage from "./pages/ExercisePage.vue";
import ArticlesPage from "./pages/ArticlesPage.vue";
import ArticlePage from "./pages/ArticlePage.vue";
import HomePageAdmin from "./pages/admin/HomePage.vue";
import ArticlesPageAdmin from "./pages/admin/ArticlesPage.vue";
import AccountPage from "./pages/AccountPage.vue";
import AuthentificationPage from "./pages/AuthentificationPage.vue";

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
    { path: "/", name: "home", component: HomePage },
    { path: "/start", component: StartPage },
    {
        name: "course",
        path: "/course/:id",
        component: CoursePage,
        props: true,
    },
    {
        name: "level",
        path: "/course/:id/level/:level_id",
        component: LevelPage,
        props: true,
    },
    // dictionnaire
    {
        name: "dictionnary",
        path: "/course/:id/level/:level_id/dictionnary",
        component: DictionnaryPage,
    },
    // dictionnaire
    {
        name: "exercise",
        path: "/course/:id/level/:level_id/exercise/:exercise_id",
        component: ExercisePage,
    },
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
