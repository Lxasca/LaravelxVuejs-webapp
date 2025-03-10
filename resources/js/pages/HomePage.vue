<template>
    <div>
        <h1>Kal<span style="color: #ffc300; font-weight: bold">ymz</span></h1>

        <div style="display: flex; justify-content: center">
            <section
                style="
                    margin-top: 50px;
                    background-color: hsl(var(--primary));
                    color: white;
                    width: 1175px;
                    padding: 50px;
                    border-radius: 10px;
                "
                class="shadow"
            >
                <p
                    style="
                        font-size: 21px;
                        font-weight: normal;
                        text-align: center;
                    "
                >
                    Chaque jour, lisez des <span>articles</span> sur des
                    <span>sujets variés</span> avec des
                    <span>aides interactives</span> pour enrichir votre
                    <span>vocabulaire</span>.
                </p>
            </section>
        </div>

        <div style="display: flex; justify-content: center; margin-top: -20px">
            <router-link to="/articles" style="margin-right: 20px">
                <Button style="background-color: #ffc300; color: black"
                    >C'est parti !</Button
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
    color: #ffc300;
}
</style>
