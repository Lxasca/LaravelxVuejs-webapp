import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import CoursesPage from "./pages/CoursesPage.vue";

const routes = [
    { path: "/", component: HomePage },
    { path: "/courses-page", component: CoursesPage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount("#app");
