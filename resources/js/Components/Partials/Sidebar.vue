<script setup>
    import { usePermission } from '@/Composables/permissions';
    import SidebarLink from '@/Components/Custom/SidebarLink.vue'
    import NavigationLink from '@/Components/Custom/NavigationLink.vue';
    import { Link } from '@inertiajs/vue3';
    import { usePage } from "@inertiajs/vue3";
    import { ref, onMounted, watchEffect } from 'vue';
    import axios from 'axios';

    const { hasPermission } = usePermission();
    const countPermissions = usePage().props.auth.user.permissions.length;
    const getUsername = usePage().props.auth.user.username;

    const countCertificate = ref("");
    onMounted(async () => {
        try {
            const response = await axios.get(`/api/countCertificate/${getUsername}`);
            countCertificate.value = response.data.count;
        } catch (error) {
            console.error('Error fetching user count:', error);
        }
    });
</script>

<script>
    export default {
        methods: {
            isRouteActive(routes) {
                return routes.some(route => this.route().current(route));
            },
            isRouteEnable(routes) {
                return routes.some(route => usePage().props.auth.user.permissions.includes(route));
            }
        }
    }
</script>

<template>
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="font-medium">
                <li>
                    <NavigationLink :href="route('dashboard')" :active="isRouteActive(['dashboard', 'home'])">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="ms-3">Beranda</span>
                    </NavigationLink>
                </li>
                <template v-if="hasPermission('notification: menu')">
                    <li>
                        <NavigationLink :href="route('notifications.index')" :active="isRouteActive(['notifications.index', 'notifications.certificate'])">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pemberitahuan</span>
                            <span v-if="countCertificate > 0" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-white bg-red-500 rounded-md dark:bg-blue-900 dark:text-blue-300">{{ countCertificate }}</span>
                        </NavigationLink>
                    </li>
                </template>
                <template v-if="hasPermission('employee: menu')">
                    <li>
                        <NavigationLink :href="route('employees.index')" :active="route().current('employees.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span class="ms-3">Pegawai</span>
                        </NavigationLink>
                    </li>
                </template>
                <li
                    :class="{ hidden: !isRouteEnable([
                        'cover-letter: menu', 'domicile-certificate: menu', 'business-certificate: menu', 'unmarried-certificate: menu', 'inability-certificate: menu'
                    ]) }"
                >
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="formulir" data-collapse-toggle="formulir">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Formulir</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul id="formulir"
                        :class="{ hidden: !isRouteActive([
                                'cover-letters.index', 'cover-letters.create', 'cover-letters.edit',
                                'domicile-certificates.index', 'domicile-certificates.create', 'domicile-certificates.edit',
                                'businessCertificates.index', 'businessCertificates.create', 'businessCertificates.edit',
                                'unmarried-certificates.index', 'unmarried-certificates.create', 'unmarried-certificates.edit',
                                'inability-certificates.index', 'inability-certificates.create', 'inability-certificates.edit'
                            ]) }"
                    >
                        <template v-if="hasPermission('cover-letter: menu')">
                            <li>
                                <SidebarLink :href="route('cover-letters.index')" :active="isRouteActive(['cover-letters.index', 'cover-letters.create', 'cover-letters.edit'])">
                                    Surat Pengantar
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('domicile-certificate: menu')">
                            <li>
                                <SidebarLink :href="route('domicile-certificates.index')" :active="isRouteActive(['domicile-certificates.index', 'domicile-certificates.create', 'domicile-certificates.edit'])">
                                    Keterangan Domisili
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('business-certificate: menu')">
                            <li>
                                <SidebarLink :href="route('businessCertificates.index')" :active="isRouteActive(['businessCertificates.index', 'businessCertificates.create', 'businessCertificates.edit'])">
                                    Keterangan Usaha
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('unmarried-certificate: menu')">
                            <li>
                                <SidebarLink :href="route('unmarried-certificates.index')" :active="isRouteActive(['unmarried-certificates.index', 'unmarried-certificates.create', 'unmarried-certificates.edit'])">
                                    Keterangan Belum Menikah
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('inability-certificate: menu')">
                            <li>
                                <SidebarLink :href="route('inability-certificates.index')" :active="isRouteActive(['inability-certificates.index', 'inability-certificates.create', 'inability-certificates.edit'])">
                                    Keterangan Tidak Mampu
                                </SidebarLink>
                            </li>
                        </template>
                    </ul>
                </li>
                <li
                    :class="{ hidden: !isRouteEnable([
                        'family-card: menu', 'resident: menu', 'birth-certificate: menu'
                    ]) }"
                >
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="data" data-collapse-toggle="data">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                        </svg>

                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Data</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul id="data"
                        :class="{ hidden: !isRouteActive([
                                'family-card.index', 'residents.index', 'birthCertificates.index'
                            ]) }"
                    >
                        <template v-if="hasPermission('family-card: menu')">
                            <li>
                                <SidebarLink :href="route('family-card.index')" :active="isRouteActive(['family-card.index'])">
                                    Kartu Keluarga
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('resident: menu')">
                            <li>
                                <SidebarLink :href="route('residents.index')" :active="isRouteActive(['residents.index'])">
                                    Penduduk
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('birth-certificate: menu')">
                            <li>
                                <SidebarLink :href="route('birthCertificates.index')" :active="isRouteActive(['birthCertificates.index'])">
                                    Akte Kelahiran
                                </SidebarLink>
                            </li>
                        </template>
                    </ul>
                </li>
                <li
                    :class="{ hidden: !isRouteEnable([
                        'user: menu', 'role: menu', 'permission: menu',
                        'position: menu', 'work: menu', 'certificate-category: menu', 'education: menu', 'approval-setting: mennu', 'rank: menu'
                    ]) }"
                >
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="pengaturan" data-collapse-toggle="pengaturan">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pengaturan</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul id="pengaturan"
                        :class="{ hidden: !isRouteActive([
                                'users.index', 'users.edit', 'users.create',
                                'roles.index', 'roles.edit', 'roles.create', 'roles.show',
                                'permissions.index', 'permissions.edit', 'permissions.create',
                                'positions.index', 'positions.edit', 'positions.create',
                                'ranks.index', 'ranks.edit', 'ranks.create',
                                'works.index',
                                'certificate-categories.index',
                                'educations.index',
                                'approvalSettings.index'
                            ]) }"
                    >
                        <template v-if="hasPermission('user: menu')">
                            <li>
                                <SidebarLink :href="route('users.index')" :active="isRouteActive(['users.index', 'users.edit', 'users.create'])">
                                    Akun
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('role: menu')">
                            <li>
                                <SidebarLink :href="route('roles.index')" :active="isRouteActive(['roles.index', 'roles.edit', 'roles.create', 'roles.show'])">
                                    Peran
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('permission: menu')">
                            <li>
                                <SidebarLink :href="route('permissions.index')" :active="isRouteActive(['permissions.index', 'permissions.edit', 'permissions.create'])">
                                    Izin
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('position: menu')">
                            <li>
                                <SidebarLink :href="route('positions.index')" :active="isRouteActive(['positions.index', 'positions.edit', 'positions.create'])">
                                    Jabatan
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('rank: menu')">
                            <li>
                                <SidebarLink :href="route('ranks.index')" :active="isRouteActive(['ranks.index', 'ranks.edit', 'ranks.create'])">
                                    Pangkat
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('work: menu')">
                            <li>
                                <SidebarLink :href="route('works.index')" :active="isRouteActive(['works.index'])">
                                    Pekerjaan
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('education: menu')">
                            <li>
                                <SidebarLink :href="route('educations.index')" :active="isRouteActive(['educations.index'])">
                                    Pendidikan
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('certificate-category: menu')">
                            <li>
                                <SidebarLink :href="route('certificate-categories.index')" :active="isRouteActive(['certificate-categories.index'])">
                                    Kategori Surat
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('approval-setting: menu')">
                            <li>
                                <SidebarLink :href="route('approvalSettings.index')" :active="isRouteActive(['approvalSettings.index'])">
                                    Pengaturan Persetujuan
                                </SidebarLink>
                            </li>
                        </template>
                        <!-- <template v-if="hasPermission('province: menu')">
                            <li>
                                <SidebarLink :href="route('provinces.index')" :active="isRouteActive(['provinces.index'])">
                                    Provinsi
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('regency: menu')">
                            <li>
                                <SidebarLink :href="route('regencies.index')" :active="isRouteActive(['regencies.index'])">
                                    Kota / Kabupaten
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('district: menu')">
                            <li>
                                <SidebarLink :href="route('districts.index')" :active="isRouteActive(['districts.index'])">
                                    Kecamatan
                                </SidebarLink>
                            </li>
                        </template>
                        <template v-if="hasPermission('village: menu')">
                            <li>
                                <SidebarLink :href="route('villages.index')" :active="isRouteActive(['villages.index'])">
                                    Kelurahan
                                </SidebarLink>
                            </li>
                        </template> -->
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
</template>
