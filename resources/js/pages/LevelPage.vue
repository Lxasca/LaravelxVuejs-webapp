<template>
    <learn-layout>
        <div>
            <h1>{{ level.name }}</h1>

            <div>
                <p>Les exercises</p>
                <section v-for="exercise in exercises" :key="exercise.id">
                    <router-link
                        :to="{ name: 'course', params: { id: level.id } }"
                        >Fermer (retour au parcours)</router-link
                    ><br />

                    Exercice n° {{ exercise.order }}

                    <div v-if="exercise.type === 'vocabulary'">
                        - Mot :
                        {{ exercise.vocabulary.word }}
                    </div>
                </section>
            </div>
        </div>
    </learn-layout>
</template>

<script>
import axios from "axios";
import LearnLayout from "../layouts/LearnLayout.vue";

export default {
    name: "LevelPage",
    components: { LearnLayout },
    data() {
        return {
            level: {},
            exercises: [],
        };
    },
    mounted() {
        this.getLevelById();
    },
    methods: {
        getLevelById() {
            const course_id = this.$route.params.id;

            axios.get(`/get-level/${course_id}`).then((response) => {
                this.level = response.data;

                // Récupération des exercises de ce niveau (Level)

                this.getExercisesOfLevel();
            });
        },
        getExercisesOfLevel() {
            const level_id = this.$route.params.level_id;

            axios
                .get(`/get-exercises-of-level/${level_id}`)
                .then((response) => {
                    this.exercises = response.data;
                });
        },
    },
};
</script>

<style scoped></style>
