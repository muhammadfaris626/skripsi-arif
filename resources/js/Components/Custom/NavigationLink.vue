<script setup>
    import { computed } from 'vue';
    import { Link } from '@inertiajs/vue3';
    const props = defineProps(["href", "active"]);
    const classes = computed(() =>
        props.active
            ? "flex items-center p-2 text-white rounded-lg dark:text-white dark:hover:bg-gray-700 group bg-blue-500 hover:bg-blue-400"
            : "flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
    );
</script>
<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
