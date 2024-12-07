<template>
    <div>cours individuel</div>
    <h1>{{ course.name }}</h1>
    <p>{{ course.description }}</p>
</template>

<script>
import axios from "axios";

export default {
    name: "Course",
    data() {
        return {
            course: {},
        };
    },
    mounted() {
        this.getCourseById();
    },
    methods: {
        getCourseById() {
            const id = this.$route.params.id;

            axios
                .get(`/get-course/${id}`)
                .then((response) => {
                    console.log("response : ", response.data);
                    this.course = response.data;
                })
                .catch((error) => {
                    console.log("error : ", error);
                });
        },
    },
};
</script>
