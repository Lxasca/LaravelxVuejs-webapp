<template>
    <div>
        <br />

        <div>
            <router-link :to="{ name: 'admin-articles' }"
                >Administration articles</router-link
            >
            <br />

            <router-link to="/mon-compte">Mon compte</router-link>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {};
</script>

<style scoped>
.error {
    color: red;
    margin-top: 10px;
}
.flex-center {
    display: flex;
    justify-content: center;
}
</style>
