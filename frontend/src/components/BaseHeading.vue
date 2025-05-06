<script setup>
defineProps({
    color: {
        type: String,
        default: 'black'
    },
    tag: {
        type: String,
        default: 'h2'
    }
});

</script>
<template>
    <component :is="tag" class="text-2xl font-bold mb-3" :style="{color: color}"><slot /></component>
</template>