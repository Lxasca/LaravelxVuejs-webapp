<template>
    <div>
        <h1>Les Parcours :</h1>

        <section v-for="course in courses" :key="course.id">
            <router-link :to="{ name: 'course', params: { id: course.id } }">
                {{ course.name }}
            </router-link>
            <p>{{ course.description }}</p>
        </section>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "CoursesPage",
    data() {
        return {
            courses: [],
        };
    },
    mounted() {
        this.getCourses();
    },
    methods: {
        getCourses() {
            axios.get("/get-courses").then((response) => {
                this.courses = response.data;
            });
        },
    },
};
</script>
