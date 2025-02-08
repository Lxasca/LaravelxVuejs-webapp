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

const requireAdminAuth = (to, from, next) => {
    if (localStorage.getItem("isAdmin") === "true") {
        next(); // ici ok, l'utilisateur est admin
    } else {
        next({ name: "admin" }); // on redirige vers la page admin principale (avec input du mdp)
    }
};

const routes = [
    { path: "/", component: HomePage },
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

    // ADMIN
    { name: "admin", path: "/admin", component: HomePageAdmin },
    {
        name: "admin-articles",
        path: "/admin/articles",
        component: ArticlesPageAdmin,
        beforeEnter: requireAdminAuth,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount("#app");
