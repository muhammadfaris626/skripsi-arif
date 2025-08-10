<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/" class="flex flex-col items-center justify-center text-center">
                <img :src="'/images/logo-surat.png'" class="w-20 mb-2" alt="FlowBite Logo" />
                <p class="text-xl font-semibold">
                    SIAK KELURAHAN KATIMBANG
                </p>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
