<script setup>
import { cn } from "../../../lib/utils";

const props = defineProps({
    class: { type: null, required: false },
});
</script>

<template>
    <h5
        :class="cn('mb-1 font-medium leading-none tracking-tight', props.class)"
        style="font-size: 18px; margin-top: 4px"
    >
        <slot />
    </h5>
</template>
