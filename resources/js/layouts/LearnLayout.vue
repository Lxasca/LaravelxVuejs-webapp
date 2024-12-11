<template>
    <div>
        <h5>Layout commun aux pages d'apprentissage pour afficher les menus</h5>

        <button>
            <router-link :to="{ name: 'course', params: { id: 1 } }"
                >Revenir au parcours</router-link
            >
        </button>
        <button>Liste mes parcours (pour switch)</button><br />

        <button>Niveaux</button>
        <button>Lecture (Compréhension / Expression écrite)</button>
        <button>Podcasts (Compréhension / Expression orale)</button>

        <button>
            <router-link
                :to="{ name: 'dictionnary', params: { id: 1, level_id: 1 } }"
            >
                Dictionnaire (vocabulaire)
            </router-link>
        </button>
        <button>Grammaire</button>
        <button>Conjugaison</button>

        <div>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "LearnLayout",
};
</script>

<style scoped></style>
