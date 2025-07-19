<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { ref, computed, watch } from 'vue';
    import { usePage, useForm, router, Head, Link } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import Table from '@/Components/Custom/Table.vue';
    import TableRow from '@/Components/Custom/TableRow.vue';
    import TableHeaderCell from '@/Components/Custom/TableHeaderCell.vue';
    import TableDataCell from '@/Components/Custom/TableDataCell.vue';
    import TablePagination from '@/Components/Custom/TablePagination.vue';
    import { usePermission } from '@/Composables/permissions';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import VueMultiselect from "vue-multiselect";
    import axios from 'axios';
    defineProps(["fetchData"]);

    const form = useForm({
        id: "",
        request_number: "",
        resident_id: "",
        name: "",
        place_of_birth: "",
        date_of_birth: "",
        gender: "",
        religion: "",
        work_id: "",
        address: "",
        resident_number: "",
        family_number: "",
        certificate_category_id: "",
        created_at: "",
        updated_at: "",
        history: ""
    });
    const { hasPermission } = usePermission();
    let search = ref(usePage().props.search), pageNumber = ref(1);
    let searchUrl = computed(() => {
        let url = new URL(route('cover-letters.index'));
        url.searchParams.append("page", pageNumber.value);
        if (search.value) {
            url.searchParams.append("search", search.value);
        }
        return url;
    });
    watch(() => searchUrl.value, (updatedSearchUrl) => {
        router.visit(updatedSearchUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });
    });
    const showModalRead = ref(false);
    const showModalUpdate = ref(false);
    const showModalDelete = ref(false);

    const closeModalRead = () => {
        showModalRead.value = false;
        form.reset();
        form.clearErrors();
    }

    const closeModalDelete = () => {
        showModalDelete.value = false;
        form.reset();
        form.clearErrors();
    }

    const modalLiatData = (data) => {
        showModalRead.value = true;
        form.id = data.id;
        form.request_number = data.request_number;
        form.resident_id = data.resident_id[0].resident_name;
        form.name = data.name;
        form.place_of_birth = data.place_of_birth;
        form.date_of_birth = data.date_of_birth;
        form.gender = data.gender;
        form.religion = data.religion;
        form.work_id = data.work_id[0].work_name;
        form.address = data.address;
        form.resident_number = data.resident_number;
        form.family_number = data.family_number;
        form.certificate_category_id = data.certificate_category_id[0].certificate_category_name;
        form.created_at = data.created_at;
        form.updated_at = data.updated_at;
        form.history = data.history;
    }

    const modalHapusData = (data) => {
        showModalDelete.value = true;
        form.id = data.id;
    }
    const lihatData = (id) => {

    }
    const ubahData = () => {
        form.put(route('cover-letters.update', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalUpdate.value = false;
            }
        });
    }
    const hapusData = () => {
        form.delete(route('cover-letters.destroy', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalDelete.value = false;
            }
        });
    }

    const statusClass = (status) => {
        return {
            'bg-green-500 text-white': status === 'Disetujui',
            'bg-blue-500 text-white': status === 'Proses',
            'bg-red-500 text-white': status !== 'Disetujui' && status !== 'Proses',
        };
    };

    const allApproved = computed(() => {
        return form.history.every(item => item.status === 'Disetujui');
    });

    const cetak = () => {
        form.get(route('cover-letters.show', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalRead.value = false;
            }
        });
    }
</script>

<template>
    <Head title="Surat Pengantar" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-1 h-full">
            <!-- <div class="bg-black mb-2 rounded-lg p-4 text-white text-xs">
                <pre>{{ JSON.stringify(test, null, 4) }}</pre>
            </div> -->
            <div class="pb-4 border-b-2 border-dashed dark:border-gray-700">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                                Formulir
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Surat Pengantar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="flex justify-between my-3">
                <div class="w-full md:w-1/4">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500 dark:text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <input v-model="search" type="text" id="input-group-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-7 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pencarian">
                    </div>
                </div>
                <div>
                    <template v-if="hasPermission('cover-letter: create')">
                        <Link :href="route('cover-letters.create')" class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Data
                        </Link>
                    </template>
                </div>
            </div>
            <Table>
                <template #header>
                    <TableRow>
                        <TableHeaderCell>NO</TableHeaderCell>
                        <TableHeaderCell>NOMOR PERMINTAAN</TableHeaderCell>
                        <TableHeaderCell>NAMA</TableHeaderCell>
                        <TableHeaderCell>NIK</TableHeaderCell>
                        <TableHeaderCell>NOMOR KK</TableHeaderCell>
                        <TableHeaderCell></TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow v-for="(data, index) in fetchData.data" :key="data.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <TableDataCell :status="'number'">{{ index+1 }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.request_number }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.resident_number }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.family_number }}</TableDataCell>
                        <TableDataCell :status="'action'">
                            <!-- Lihat Data  -->
                            <template v-if="hasPermission('cover-letter: read')">
                                <button @click="modalLiatData(data)" class="text-white mr-1 bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Ubah Data  -->
                            <template v-if="hasPermission('cover-letter: update')">
                                <button @click="modalUbahData(data)" class="text-white mr-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Hapus Data  -->
                            <template v-if="hasPermission('cover-letter: delete')">
                                <button @click="modalHapusData(data)" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </template>
                        </TableDataCell>
                    </TableRow>
                </template>
                <template #pagination>
                    <TablePagination :pagination="fetchData.meta" />
                </template>
            </Table>
            <!-- Modal Lihat Data  -->
            <Modal :show="showModalRead" @close="closeModalRead">
                <div class="relative w-full max-w-3xl max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            LIHAT SURAT PENGANTAR
                        </h3>
                        <button v-if="allApproved" @click="cetak" type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            UNDUH
                        </button>
                    </div>
                    <div class="py-2">
                        <div class="relative overflow-x-auto">
                            <table class="table-collapse w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            ID
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NOMOR PERMINTAAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.request_number }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            YANG MENGAJUKAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.resident_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NAMA
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.name }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            TEMPAT LAHIR
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.place_of_birth }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            TANGGAL LAHIR
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.date_of_birth }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            JENIS KELAMIN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.gender }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            AGAMA
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.religion }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            PEKERJAAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.work_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            ALAMAT
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.address }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NOMOR INDUK KEPENDUDUKAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.resident_number }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NOMOR KARTU KELUARGA
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.family_number }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            JENIS SURAT
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.certificate_category_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            STATUS PERSETUJUAN
                                        </th>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-between my-3" v-for="history in form.history" :key="history.id">
                                                <div>
                                                    {{ history.step }}.
                                                    {{ history.approver.employee[0].name }}
                                                </div>
                                                <div>
                                                    <span :class="statusClass(history.status)" class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                        {{ history.status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            TANGGAL DIBUAT
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.created_at }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            TANGGAL DIUBAH
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.updated_at }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </Modal>
            <!-- Modal Hapus Data  -->
            <Modal :show="showModalDelete" @close="closeModalDelete">
                <div class="relative w-full max-w-3xl max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Apakah anda yakin ingin menghapus surat pengantar ini ?
                        </h3>
                        <button @click="hapusData" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Iya, Saya yakin
                        </button>
                        <button @click="closeModalDelete" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Tidak, Batalkan
                        </button>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
