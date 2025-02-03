<template>
    <div>
        <h1>Administration</h1>

        <router-link :to="{ name: 'admin-articles' }"
            >Administration articles</router-link
        >
    </div>
</template>

<script>
export default {
    name: "HomePageAdmin",
};
</script>
