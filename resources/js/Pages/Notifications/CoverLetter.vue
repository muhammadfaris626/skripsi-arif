<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { ref, computed, watch } from 'vue';
    import { usePage, useForm, router, Head, Link } from '@inertiajs/vue3';
    import Table from '@/Components/Custom/Table.vue';
    import TableRow from '@/Components/Custom/TableRow.vue';
    import TableHeaderCell from '@/Components/Custom/TableHeaderCell.vue';
    import TableDataCell from '@/Components/Custom/TableDataCell.vue';
    import TablePagination from '@/Components/Custom/TablePagination.vue';
    import Modal from '@/Components/Modal.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import InputError from '@/Components/InputError.vue';
    import { usePermission } from '@/Composables/permissions';
    defineProps(["fetchData"]);

    const form = useForm({
        id: "",
        request_number: "",
        user_id: "",
        resident_id: "",
        name: "",
        place_of_birth: "",
        date_of_birth: "",
        religion: "",
        work_id: "",
        address: "",
        resident_number: "",
        family_number: "",
        certificate_category_id: "",
        created_at: "",
        updated_at: "",
        history: "",
        statusApproval: "",
        approvalCategory: ""
    });

    const { hasPermission } = usePermission();
    let certificate = ref(usePage().props.certificate);
    let search = ref(usePage().props.search), pageNumber = ref(1);
    let searchUrl = computed(() => {
        let url = new URL(route('notifications.certificate', { certificate:certificate.value }));
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
    const closeModalRead = () => {
        showModalRead.value = false;
        form.reset();
        form.clearErrors();
    }
    const modalLiatData = (data) => {
        showModalRead.value = true;
        form.id = data.id;
        form.request_number = data.certificate_id[0].request_number;
        form.resident_id = data.certificate_id[0].name;
        form.user_id = data.certificate_id.user_id;
        form.name = data.certificate_id[0].name;
        form.place_of_birth = data.certificate_id[0].place_of_birth;
        form.date_of_birth = data.certificate_id[0].date_of_birth;
        form.religion = data.certificate_id[0].religion;
        form.work_id = data.certificate_id[0].work_id[0].work_name;
        form.address = data.certificate_id[0].address;
        form.resident_number = data.certificate_id[0].resident_number;
        form.family_number = data.certificate_id[0].family_number;
        form.certificate_category_id = data.certificate_id[0].certificate_category_id[0].certificate_category_name;
        form.created_at = data.certificate_id[0].created_at;
        form.updated_at = data.certificate_id[0].updated_at;
        form.history = data.certificate_id[0].history;
    }
    const showModalUpdate = ref(false);
    const closeModalUpdate = () => {
        showModalUpdate.value = false;
        form.reset();
        form.clearErrors();
    }
    const modalUbahData = (data) => {
        showModalUpdate.value = true;
        form.id = data.id;
        form.approvalCategory = data.certificate_category_id[0].certificate_category_name;
    }
    const ubahData = () => {
        form.put(route('notifications.update', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalUpdate.value = false;
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
</script>
<template>
    <Head title="Pelacakan Persetujuan" />
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
            </div>
            <Table>
                <template #header>
                    <TableRow>
                        <TableHeaderCell>NO</TableHeaderCell>
                        <TableHeaderCell class="whitespace-nowrap">KATEGORI PERSETUJUAN</TableHeaderCell>
                        <TableHeaderCell class="whitespace-nowrap">NOMOR PERMINTAAN</TableHeaderCell>
                        <TableHeaderCell class="whitespace-nowrap">YANG MENGAJUKAN</TableHeaderCell>
                        <TableHeaderCell class="whitespace-nowrap">TANGGAL DIBUAT</TableHeaderCell>
                        <TableHeaderCell class="whitespace-nowrap"></TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow v-for="(data, index) in fetchData.data" :key="data.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <TableDataCell :status="'number'">{{ index+1 }}</TableDataCell>
                        <TableDataCell :status="'record'" class="whitespace-nowrap">{{ data.certificate_category_id[0].certificate_category_name }}</TableDataCell>
                        <TableDataCell :status="'record'" class="whitespace-nowrap">{{ data.certificate_id[0].request_number }}</TableDataCell>
                        <TableDataCell :status="'record'" class="whitespace-nowrap">{{ data.certificate_id[0].name }}</TableDataCell>
                        <TableDataCell :status="'record'" class="whitespace-nowrap">{{ data.certificate_id[0].created_at }}</TableDataCell>
                        <TableDataCell :status="'action'" class="whitespace-nowrap">
                            <!-- Lihat Data  -->
                            <template v-if="hasPermission('notification: read')">
                                <button @click="modalLiatData(data)" class="text-white mr-1 bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Ubah Data  -->
                            <template v-if="hasPermission('notification: update')">
                                <button v-if="data.is_active == '1'" @click="modalUbahData(data)" class="text-white mr-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
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
                            LIHAT SURAT KETERANGAN DOMISILI
                        </h3>
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
                                                    {{ history.step }}. {{ history.approver.employee[0].name }}
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
            <!-- Modal Ubah Data  -->
            <Modal :show="showModalUpdate" @close="closeModalUpdate">
                <div class="relative w-full max-w-3xl max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            PELACAKAN PERSETUJUAN
                        </h3>
                    </div>
                    <form @submit.prevent="ubahData">
                        <div class="px-4 py-2 grid grid-cols-2 gap-2">
                            <div>
                                <InputLabel for="statusApproval" value="Status" />
                                <select v-model="form.statusApproval" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled>Pilih status persetujuan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <!-- <option value="Ditolak">Ditolak</option> -->
                                </select>
                                <InputError :message="form.errors.statusApproval" />
                            </div>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit" class="text-white uppercase bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
