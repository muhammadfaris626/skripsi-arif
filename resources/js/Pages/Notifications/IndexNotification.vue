<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { usePage, useForm, router, Head, Link } from '@inertiajs/vue3';
    defineProps(['countCoverLetter', 'countDomicileCertificate', 'countBusinessCertificate', 'countUnmarriedCertificate', 'countInabilityCertificate']);
</script>

<template>
    <Head title="Pemberitahuan" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-1 h-full">
            <div class="pb-4 border-b-2 border-dashed dark:border-gray-700">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                </svg>
                                Pemberitahuan
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <Link :href="route('notifications.certificate', 'cover-letter')" class="border-2 p-2 rounded-lg hover:bg-blue-500 hover:text-white hover:border-blue-600">
                    <div>
                        <p class="uppercase text-xl">Surat Pengantar</p>
                        <p class="font-bold text-3xl">{{ countCoverLetter }}</p>
                    </div>
                </Link>
                <Link :href="route('notifications.certificate', 'domicile-certificate')" class="border-2 p-2 rounded-lg hover:bg-blue-500 hover:text-white hover:border-blue-600">
                    <div>
                        <p class="uppercase text-xl">Surat Keterangan Domisili</p>
                        <p class="font-bold text-3xl">{{ countDomicileCertificate }}</p>
                    </div>
                </Link>
                <Link :href="route('notifications.certificate', 'business-certificate')" class="border-2 p-2 rounded-lg hover:bg-blue-500 hover:text-white hover:border-blue-600">
                    <div>
                        <p class="uppercase text-xl">Surat Keterangan Usaha</p>
                        <p class="font-bold text-3xl">{{ countBusinessCertificate }}</p>
                    </div>
                </Link>
                <Link :href="route('notifications.certificate', 'unmarried-certificate')" class="border-2 p-2 rounded-lg hover:bg-blue-500 hover:text-white hover:border-blue-600">
                    <div>
                        <p class="uppercase text-xl">Surat Keterangan Belum Menikah</p>
                        <p class="font-bold text-3xl">{{ countUnmarriedCertificate }}</p>
                    </div>
                </Link>
                <Link :href="route('notifications.certificate', 'inability-certificate')" class="border-2 p-2 rounded-lg hover:bg-blue-500 hover:text-white hover:border-blue-600">
                    <div>
                        <p class="uppercase text-xl">Surat Keterangan Tidak Mampu</p>
                        <p class="font-bold text-3xl">{{ countInabilityCertificate }}</p>
                    </div>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
