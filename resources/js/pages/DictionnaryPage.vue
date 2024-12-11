<template>
    <learn-layout>
        <div>
            <h1>Dictionnaire</h1>

            <!-- affichage de tous les mots de vocabulaires d'un parcours donné (actif) lié à un exercice donné (dernier débloqué par l'user) -->
            <section v-for="vocabulary in vocabularies" :key="vocabulary.id">
                <p>{{ vocabulary.word }}</p>
            </section>
        </div>
    </learn-layout>
</template>

<script>
import axios from "axios";
import LearnLayout from "../layouts/LearnLayout.vue";

export default {
    name: "DictionnaryPage",
    components: { LearnLayout },
    data() {
        return {
            vocabularies: [],
        };
    },
    mounted() {
        this.getVocabularies();
    },
    methods: {
        getVocabularies() {
            const course_id = this.$route.params.id;
            const level_id = this.$route.params.level_id;

            axios
                .get(`/get-vocabularies/${course_id}/${level_id}`)
                .then((response) => {
                    console.log("succès : ", response.data);
                    this.vocabularies = response.data;
                })
                .catch((error) => {
                    console.log("erreur : ", error);
                });
        },
    },
};
</script>
