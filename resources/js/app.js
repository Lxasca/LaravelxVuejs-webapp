import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import CoursePage from "./pages/CoursePage.vue";
import LevelPage from "./pages/LevelPage.vue";
import StartPage from "./pages/StartPage.vue";

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount("#app");
