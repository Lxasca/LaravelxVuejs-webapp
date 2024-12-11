<template>
    <div>
        <h5>Layout commun aux pages d'apprentissage pour afficher les menus</h5>

        <button>Liste mes parcours (pour switch)</button><br />
        <button>Niveaux</button>
        <button>Lecture (Compréhension / Expression écrite)</button>
        <button>Podcasts (Compréhension / Expression orale)</button>
        <button>Dictionnaire (vocabulaire)</button>
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
