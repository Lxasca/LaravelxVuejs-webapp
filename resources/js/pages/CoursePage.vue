<template>
    <learn-layout>
        <div>
            <h1>Parcours {{ course.name }}</h1>
            <p>{{ course.description }}</p>

            <section v-for="level in levels" :key="level.id">
                {{ level.name }}
                <router-link
                    :to="{
                        name: 'level',
                        params: { id: course.id, level_id: level.id },
                    }"
                >
                    Voir
                </router-link>
            </section>
        </div>
    </learn-layout>
</template>

<script>
import axios from "axios";
import LearnLayout from "../layouts/LearnLayout.vue";

export default {
    name: "Course",
    components: { LearnLayout },
    data() {
        return {
            course: {},
            levels: [],
        };
    },
    mounted() {
        this.getCourseById();
    },
    methods: {
        getCourseById() {
            const id = this.$route.params.id;

            axios.get(`/get-course/${id}`).then((response) => {
                this.course = response.data;

                this.getLevelsOfCourse();
            });
        },
        getLevelsOfCourse() {
            const id = this.$route.params.id;

            axios.get(`/get-levels-of-course/${id}`).then((response) => {
                this.levels = response.data;
            });
        },
    },
};
</script>
