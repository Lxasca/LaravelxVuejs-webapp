<template>
    <div>
        <h1>{{ level.name }}</h1>

        <div>
            <p>Les exercises</p>
            <section v-for="exercise in exercises" :key="exercise.id">
                Exercice n° {{ exercise.order }}

                <div v-if="exercise.type === 'vocabulary'">
                    - Mot :
                    {{ exercise.vocabulary.word }}
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "LevelPage",
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
