<template>
    <label>
        <input
            type="radio"
            :name="name"
            :value="value"
            :checked="modelValue === value"
            @change="handleClick"
            hidden
        />
        <span>{{ label }}</span>
    </label>
</template>

<script>
export default {
    name: "InputChoice",
    props: {
        name: {
            type: String,
            required: true,
        },
        value: {
            type: [String, Number],
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        modelValue: {
            type: [String, Number],
            required: true,
        },
        onClick: {
            type: Function,
            required: false,
            default: null,
        },
    },
    methods: {
        handleClick() {
            if (this.onClick) {
                this.onClick(this.value);
            }
            this.$emit("update:modelValue", this.value);
        },
    },
};
</script>
