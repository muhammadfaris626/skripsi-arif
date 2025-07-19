<script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
        pagination: Object
    });
</script>
<template>
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
            Showing
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ pagination.from }} - {{ pagination.to }}
            </span>
            of
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ pagination.total }}
            </span>
        </span>
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <li v-for="(link, index) in pagination.links" :key="link.label" class="text-white">
                <div v-if="index == 0">
                    <Link preserve-scroll :href="link.url ?? ''" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Sebelumnya
                    </Link>
                </div>
                <div v-else-if="index == pagination.links.length-1">
                    <Link preserve-scroll :href="link.url ?? ''" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Selanjutnya
                    </Link>
                </div>
                <div v-else>
                    <Link v-if="link.active" preserve-scroll :href="link.url ?? ''" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                        {{ link.label }}
                    </Link>
                    <Link v-else preserve-scroll :href="link.url ?? ''" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        {{ link.label }}
                    </Link>
                </div>
            </li>
        </ul>
    </nav>
</template>
