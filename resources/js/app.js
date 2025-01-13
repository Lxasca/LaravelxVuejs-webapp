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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount("#app");
