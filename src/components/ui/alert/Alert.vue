<script setup>
import { cn } from "../../../lib/utils";
import { alertVariants } from ".";

const props = defineProps({
    class: { type: null, required: false },
    variant: { type: null, required: false },
});
</script>

<template>
    <div
        :class="cn(alertVariants({ variant }), props.class)"
        role="alert"
        style="width: 372.5px"
    >
        <slot />
    </div>
</template>
