<template>
    <div>
        <h3>Les Parcours :</h3>

        <section v-for="course in courses" :key="course.id">
            <h4>{{ course.name }}</h4>
            <p>{{ course.description }}</p>
        </section>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "CoursesComponent",
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
