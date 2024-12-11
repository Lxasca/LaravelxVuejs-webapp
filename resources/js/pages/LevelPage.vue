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

                    <div v-else-if="exercise.type === 'vocabulary-multiple'">
                        - Mots :
                        <ul>
                            <li
                                v-for="vocabulary in vocabularyMultiple"
                                :key="vocabulary.id"
                            >
                                {{ vocabulary.word }}
                            </li>
                        </ul>
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
            vocabularyMultiple: [],
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

                    this.getVocabularyMultiple(this.exercises);
                });
        },
        getVocabularyMultiple(exercicesOfLevel) {
            const filteredExercises = exercicesOfLevel.filter((exercise) => {
                return (
                    exercise.vocabularies && exercise.vocabularies.length > 0
                );
            });

            filteredExercises.forEach((exercise) => {
                const vocabulariesArray = JSON.parse(exercise.vocabularies); // on le transforme en objet pour foreach dessus, car reçu en chaine de caractère

                vocabulariesArray.forEach((id) => {
                    axios.get(`/get-vocabulary/${id}`).then((response) => {
                        this.vocabularyMultiple.push(response.data);

                        // On récupère chaque mot stocké dans le tableau, et pour chaque mot on le get puis on le push dans vocabularyMultiple pour l'afficher dans le v-for
                    });
                });
            });
        },
    },
};
</script>

<style scoped></style>
