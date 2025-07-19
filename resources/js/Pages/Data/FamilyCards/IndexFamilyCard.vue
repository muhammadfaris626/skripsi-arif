<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { ref, computed, watch } from 'vue';
    import { usePage, useForm, router, Head } from '@inertiajs/vue3';
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
    defineProps(["fetchData", 'provinces']);
    const form = useForm({
        id: "",
        family_number: "",
        name: "",
        address: "",
        rt: "",
        rw: "",
        province_id: "",
        regency_id: "",
        district_id: "",
        village_id: "",
        postal_code: "",
        created_at: "",
        updated_at: ""
    });
    const { hasPermission } = usePermission();
    let search = ref(usePage().props.search), pageNumber = ref(1);
    let searchUrl = computed(() => {
        let url = new URL(route('family-card.index'));
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

    const showModalCreate = ref(false);
    const showModalRead = ref(false);
    const showModalUpdate = ref(false);
    const showModalDelete = ref(false);

    const closeModalCreate = () => {
        showModalCreate.value = false;
    }
    const closeModalRead = () => {
        showModalRead.value = false;
        form.reset();
        form.clearErrors();
    }
    const closeModalUpdate = () => {
        showModalUpdate.value = false;
        form.reset();
        form.clearErrors();
    }
    const closeModalDelete = () => {
        showModalDelete.value = false;
        form.reset();
        form.clearErrors();
    }

    const modalTambahData = () => { showModalCreate.value = true; }
    const modalLiatData = (data) => {
        showModalRead.value = true;
        form.id = data.id;
        form.family_number = data.family_number;
        form.name = data.name;
        form.address = data.address;
        form.rt = data.rt;
        form.rw = data.rw;
        form.province_id = data.province_id[0].name;
        form.regency_id = data.regency_id[0].name;
        form.district_id = data.district_id[0].name;
        form.village_id = data.village_id[0].name;
        form.postal_code = data.postal_code;
        form.created_at = data.created_at;
        form.updated_at = data.updated_at;
    }

    const modalUbahData = (data) => {
        showModalUpdate.value = true;
        form.id = data.id;
        form.family_number = data.family_number;
        form.name = data.name;
        form.address = data.address;
        form.rt = data.rt;
        form.rw = data.rw;
        form.province_id = data.province_id;
        form.regency_id = data.regency_id;
        form.district_id = data.district_id;
        form.village_id = data.village_id;
        form.postal_code = data.postal_code;
    }
    const modalHapusData = (data) => {
        showModalDelete.value = true;
        form.id = data.id;
    }

    const tambahData = () => {
        form.post(route('family-card.store'), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalCreate.value = false;
            }
        });
    }
    const lihatData = (id) => {

    }
    const ubahData = () => {
        form.put(route('family-card.update', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalUpdate.value = false;
            }
        });
    }
    const hapusData = () => {
        form.delete(route('family-card.destroy', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalDelete.value = false;
            }
        });
    }

    const retrieveRegency = ref([]);
    const retrieveDistrict = ref([]);
    const retrieveVillage = ref([]);

    const getRegency = async () => {
        try {
            retrieveDistrict.value = [];
            form.district_id = '';
            retrieveVillage.value = [];
            form.village_id = '';
            const response = await axios.get(`api/get-regency/${form.province_id.id}`);
            form.regency_id = '';
            retrieveRegency.value = response.data;
        } catch (error) {
            console.log(error);
        }
    }

    const getDistrict = async () => {
        try {
            retrieveVillage.value = [];
            form.village_id = '';
            const response = await axios.get(`api/get-district/${form.regency_id.id}`);
            form.district_id = '';
            retrieveDistrict.value = response.data;
        } catch (error) {
            console.log(error);
        }
    }

    const getVillage = async () => {
        try {
            const response = await axios.get(`api/get-village/${form.district_id.id}`);
            form.village_id = '';
            retrieveVillage.value = response.data;
        } catch (error) {
            console.log(error);
        }
    }

    const fetchRegency = async () => {
        try {
            const response = await axios.get(`api/get-regency/${form.province_id[0].id}`);
            retrieveRegency.value = response.data;
        } catch (error) {
            // console.log(error);
        }
    }

    const fetchDistrict = async () => {
        try {
            const response = await axios.get(`api/get-district/${form.regency_id[0].id}`);
            retrieveDistrict.value = response.data;
        } catch (error) {
            // console.log(error);
        }
    }

    const fetchVillage = async () => {
        try {
            const response = await axios.get(`api/get-village/${form.district_id[0].id}`);
            retrieveVillage.value = response.data;
        } catch (error) {
            // console.log(error);
        }
    }
</script>

<template>
    <Head title="Kartu Keluarga" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-1 h-full">
            <div class="pb-4 border-b-2 border-dashed dark:border-gray-700">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                </svg>
                                Data
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Kartu Keluarga</span>
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
                    <template v-if="hasPermission('family-card: create')">
                        <button @click="modalTambahData()" class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Data
                        </button>
                        <Modal :show="showModalCreate" @close="closeModalCreate">
                            <div class="relative w-full max-w-3xl max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        TAMBAH KARTU KELUARGA
                                    </h3>
                                </div>
                                <form @submit.prevent="tambahData">
                                    <div class="px-4 py-2 grid grid-cols-2 gap-2 mb-2">
                                        <div>
                                            <InputLabel for="family_number">
                                                Nomor Kartu Keluarga <span class="text-red-500">*</span>
                                            </InputLabel>

                                            <TextInput
                                                id="family_number"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.family_number"
                                            />
                                            <InputError :message="form.errors.family_number" />
                                        </div>
                                        <div>
                                            <InputLabel for="name">
                                                Nama Kepala Keluarga <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <TextInput
                                                id="name"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.name"
                                            />
                                            <InputError :message="form.errors.name" />
                                        </div>
                                        <div>
                                            <InputLabel for="address">
                                                Alamat Lengkap <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <TextInput
                                                id="address"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.address"
                                            />
                                            <InputError :message="form.errors.address" />
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <InputLabel for="rt">
                                                    RT <span class="text-red-500">*</span>
                                                </InputLabel>
                                                <TextInput
                                                    id="rt"
                                                    type="text"
                                                    class="block w-full"
                                                    v-model="form.rt"
                                                />
                                                <InputError :message="form.errors.rt" />
                                            </div>
                                            <div>
                                                <InputLabel for="rw">
                                                    RW <span class="text-red-500">*</span>
                                                </InputLabel>
                                                <TextInput
                                                    id="rw"
                                                    type="text"
                                                    class="block w-full"
                                                    v-model="form.rw"
                                                />
                                                <InputError :message="form.errors.rw" />
                                            </div>
                                        </div>
                                        <div>
                                            <InputLabel for="province_id">
                                                Provinsi <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <VueMultiselect
                                                @select="getRegency"
                                                v-model="form.province_id"
                                                :options="provinces"
                                                :close-on-select="true"
                                                placeholder="Pilih provinsi"
                                                label="name" track-by="id"
                                            />
                                            <InputError :message="form.errors.province_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="regency_id">
                                                Kota / Kabupaten <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <VueMultiselect
                                                @select="getDistrict"
                                                v-model="form.regency_id"
                                                :options="retrieveRegency"
                                                :close-on-select="true"
                                                placeholder="Pilih kota / kabupaten"
                                                label="name" track-by="id"
                                            />
                                            <InputError :message="form.errors.regency_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="district_id">
                                                Kecamatan <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <VueMultiselect
                                                @select="getVillage"
                                                v-model="form.district_id"
                                                :options="retrieveDistrict"
                                                :close-on-select="true"
                                                placeholder="Pilih kecamatan"
                                                label="name" track-by="id"
                                            />
                                            <InputError :message="form.errors.district_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="village_id">
                                                Kelurahan <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <VueMultiselect
                                                v-model="form.village_id"
                                                :options="retrieveVillage"
                                                :close-on-select="true"
                                                placeholder="Pilih kelurahan"
                                                label="name" track-by="id"
                                            />
                                            <InputError :message="form.errors.village_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="postal_code">
                                                Kode Pos <span class="text-red-500">*</span>
                                            </InputLabel>
                                            <TextInput
                                                id="postal_code"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.postal_code"
                                            />
                                            <InputError :message="form.errors.postal_code" />
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                        <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit" class="text-white uppercase bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </Modal>
                    </template>
                </div>
            </div>
            <Table>
                <template #header>
                    <TableRow>
                        <TableHeaderCell>NO</TableHeaderCell>
                        <TableHeaderCell>NOMOR KK</TableHeaderCell>
                        <TableHeaderCell>NAMA</TableHeaderCell>
                        <TableHeaderCell>PROVINSI</TableHeaderCell>
                        <TableHeaderCell>KABUPATEN</TableHeaderCell>
                        <TableHeaderCell>KECAMATAN</TableHeaderCell>
                        <TableHeaderCell>KELURAHAN</TableHeaderCell>
                        <TableHeaderCell></TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow v-for="(data, index) in fetchData.data" :key="data.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <TableDataCell :status="'number'">{{ index+1 }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.family_number }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.province_id[0].name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.regency_id[0].name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.district_id[0].name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.village_id[0].name }}</TableDataCell>
                        <TableDataCell :status="'action'">
                            <!-- Lihat Data  -->
                            <template v-if="hasPermission('family-card: read')">
                                <button @click="modalLiatData(data)" class="text-white mr-1 bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Ubah Data  -->
                            <template v-if="hasPermission('family-card: update')">
                                <button @click="modalUbahData(data)" class="text-white mr-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Hapus Data  -->
                            <template v-if="hasPermission('family-card: delete')">
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
                            LIHAT KARTU KELUARGA
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
                                            NOMOR KARTU KELUARGA
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.family_number }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NAMA KEPALA KELUARGA
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.name }}
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
                                            RT
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.rt }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            RW
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.rw }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            PROVINSI
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.province_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            KOTA / KABUPATEN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.regency_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            KECAMATAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.district_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            KELURAHAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.village_id }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            KODE POS
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.postal_code }}
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
                            UBAH PEGAWAI
                        </h3>
                    </div>
                    <form @submit.prevent="ubahData">
                        <div class="px-4 py-2 grid grid-cols-2 gap-2 mb-2">
                            <div>
                                <InputLabel for="family_number">
                                    Nomor Kartu Keluarga <span class="text-red-500">*</span>
                                </InputLabel>

                                <TextInput
                                    id="family_number"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.family_number"
                                />
                                <InputError :message="form.errors.family_number" />
                            </div>
                            <div>
                                <InputLabel for="name">
                                    Nama Kepala Keluarga <span class="text-red-500">*</span>
                                </InputLabel>
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.name"
                                />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="address">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </InputLabel>
                                <TextInput
                                    id="address"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.address"
                                />
                                <InputError :message="form.errors.address" />
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <InputLabel for="rt">
                                        RT <span class="text-red-500">*</span>
                                    </InputLabel>
                                    <TextInput
                                        id="rt"
                                        type="text"
                                        class="block w-full"
                                        v-model="form.rt"
                                    />
                                    <InputError :message="form.errors.rt" />
                                </div>
                                <div>
                                    <InputLabel for="rw">
                                        RW <span class="text-red-500">*</span>
                                    </InputLabel>
                                    <TextInput
                                        id="rw"
                                        type="text"
                                        class="block w-full"
                                        v-model="form.rw"
                                    />
                                    <InputError :message="form.errors.rw" />
                                </div>
                            </div>
                            <div>
                                <InputLabel for="province_id">
                                    Provinsi <span class="text-red-500">*</span>
                                </InputLabel>
                                <VueMultiselect
                                    @select="getRegency"
                                    v-model="form.province_id"
                                    :options="provinces"
                                    :close-on-select="true"
                                    placeholder="Pilih provinsi"
                                    label="name" track-by="id"
                                />
                                <InputError :message="form.errors.province_id" />
                            </div>
                            <div>
                                <InputLabel for="regency_id">
                                    Kota / Kabupaten <span class="text-red-500">*</span>
                                </InputLabel>
                                <VueMultiselect
                                    @select="getDistrict"
                                    v-model="form.regency_id"
                                    :options="retrieveRegency"
                                    :close-on-select="true"
                                    placeholder="Pilih kota / kabupaten"
                                    label="name" track-by="id"
                                />
                                <InputError :message="form.errors.regency_id" />
                            </div>
                            <div>
                                <InputLabel for="district_id">
                                    Kecamatan <span class="text-red-500">*</span>
                                </InputLabel>
                                <VueMultiselect
                                    @select="getVillage"
                                    v-model="form.district_id"
                                    :options="retrieveDistrict"
                                    :close-on-select="true"
                                    placeholder="Pilih kecamatan"
                                    label="name" track-by="id"
                                />
                                <InputError :message="form.errors.district_id" />
                            </div>
                            <div>
                                <InputLabel for="village_id">
                                    Kelurahan <span class="text-red-500">*</span>
                                </InputLabel>
                                <VueMultiselect
                                    v-model="form.village_id"
                                    :options="retrieveVillage"
                                    :close-on-select="true"
                                    placeholder="Pilih kelurahan"
                                    label="name" track-by="id"
                                />
                                <InputError :message="form.errors.village_id" />
                            </div>
                            <div>
                                <InputLabel for="postal_code">
                                    Kode Pos <span class="text-red-500">*</span>
                                </InputLabel>
                                <TextInput
                                    id="postal_code"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.postal_code"
                                />
                                <InputError :message="form.errors.postal_code" />
                            </div>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit" class="text-white uppercase bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ubah</button>
                        </div>
                    </form>
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
                            Apakah anda yakin ingin menghapus data kartu keluarga ini ?
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
