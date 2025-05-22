<template>
    <div style="margin-top: 8.5%; left: 50%">
        <h1>Kal<span style="color: #58ca60; font-weight: bold">ymz</span></h1>

        <div style="display: flex; justify-content: center">
            <section>
                <p>
                    Chaque jour, lisez des articles arabe / français sur des
                    sujets variés avec des aides interactives pour enrichir
                    votre vocabulaire.
                </p>
            </section>
        </div>

        <div style="display: flex; justify-content: center; margin-top: 20px">
            <router-link to="/articles">
                <Button
                    style="
                        background-color: #58ca60;
                        color: white;
                        padding-left: 25px;
                        padding-right: 25px;
                        font-size: 17px;
                    "
                    >Je veux apprendre l'arabe</Button
                >
            </router-link>
        </div>
    </div>
</template>

<script>
import { Button } from "../../../src/components/ui/button";

export default {
    name: "HomePage",
    components: { Button },
};
</script>

<style scoped>
span {
    color: #58ca60;
}

p {
    font-size: 21px;
    font-weight: normal;
    text-align: center;
}
section {
    width: 550px;
}

@media (max-width: 767px) {
    p {
        font-size: 16px;
    }
    section {
        width: 350px;
    }
}
</style>
