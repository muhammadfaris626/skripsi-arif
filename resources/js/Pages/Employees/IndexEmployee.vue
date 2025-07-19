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
    defineProps(["fetchData", 'positions', 'educations', 'ranks']);
    const form = useForm({
        id: "",
        employee_number: "",
        name: "",
        gender: "",
        address: "",
        phone: "",
        effective_date: "",
        position_id: "",
        rank_id: "",
        employee_status: "",
        blood_group: "",
        education_id: "",
        created_at: "",
        updated_at: ""
    });
    const { hasPermission } = usePermission();
    let search = ref(usePage().props.search), pageNumber = ref(1);
    let searchUrl = computed(() => {
        let url = new URL(route('employees.index'));
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
        form.employee_number = data.employee_number;
        form.name = data.name;
        form.gender = data.gender;
        form.address = data.address;
        form.phone = data.phone;
        form.effective_date = data.tanggal_mulai_kerja;
        form.position_id = data.position_id;
        form.rank_id = data.rank_id;
        form.employee_status = data.employee_status;
        form.blood_group = data.blood_group;
        form.education_id = data.education_id;
        form.created_at = data.created_at;
        form.updated_at = data.updated_at;
    }

    const modalUbahData = (data) => {
        showModalUpdate.value = true;
        form.id = data.id;
        form.employee_number = data.employee_number;
        form.name = data.name;
        form.gender = data.gender;
        form.address = data.address;
        form.phone = data.phone;
        form.effective_date = data.effective_date;
        form.position_id = data.position_id[0].id;
        form.rank_id = data.rank_id[0].id;
        form.employee_status = data.employee_status;
        form.blood_group = data.blood_group;
        form.education_id = data.education_id[0];
    }
    const modalHapusData = (data) => {
        showModalDelete.value = true;
        form.id = data.id;
    }

    const tambahData = () => {
        form.post(route('employees.store'), {
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
        form.put(route('employees.update', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalUpdate.value = false;
            }
        });
    }
    const hapusData = () => {
        form.delete(route('employees.destroy', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalDelete.value = false;
            }
        });
    }
</script>

<template>
    <Head title="Pegawai" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-1 h-full">
            <div class="pb-4 border-b-2 border-dashed dark:border-gray-700">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                Pegawai
                            </a>
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
                    <template v-if="hasPermission('employee: create')">
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
                                        TAMBAH PEGAWAI
                                    </h3>
                                </div>
                                <form @submit.prevent="tambahData">
                                    <div class="px-4 py-2 grid grid-cols-2 gap-2">
                                        <div>
                                            <InputLabel for="employee_number" value="Nomor Pegawai" />
                                            <TextInput
                                                id="employee_number"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.employee_number"
                                            />
                                            <InputError :message="form.errors.employee_number" />
                                        </div>
                                        <div>
                                            <InputLabel for="name" value="Nama Lengkap" />
                                            <TextInput
                                                id="name"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.name"
                                            />
                                            <InputError :message="form.errors.name" />
                                        </div>
                                        <div>
                                            <InputLabel for="gender" value="Jenis Kelamin" />
                                            <select v-model="form.gender" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="" disabled>Pilih jenis kelamin</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                            <InputError :message="form.errors.gender" />
                                        </div>
                                        <div>
                                            <InputLabel for="address" value="Alamat" />
                                            <TextInput
                                                id="address"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.address"
                                            />
                                            <InputError :message="form.errors.address" />
                                        </div>
                                        <div>
                                            <InputLabel for="phone" value="Nomor Telepon" />
                                            <TextInput
                                                id="phone"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.phone"
                                            />
                                            <InputError :message="form.errors.phone" />
                                        </div>
                                        <div>
                                            <InputLabel for="education_id" value="Pendidikan Terakhir" />
                                            <VueMultiselect
                                                v-model="form.education_id"
                                                :options="educations"
                                                :close-on-select="true"
                                                placeholder="Pilih pendidikan"
                                                label="education_name" track-by="id"
                                            />
                                            <InputError :message="form.errors.education_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="effective_date" value="Tanggal Awal Kerja" />
                                            <TextInput
                                                id="effective_date"
                                                type="date"
                                                class="block w-full"
                                                v-model="form.effective_date"
                                            />
                                            <InputError :message="form.errors.effective_date" />
                                        </div>
                                        <div>
                                            <InputLabel for="position_d" value="Jabatan" />
                                            <select v-model="form.position_id" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="" disabled>Pilih jabatan</option>
                                                <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.position_name }}</option>
                                            </select>
                                            <InputError :message="form.errors.position_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="rank_id" value="Jabatan" />
                                            <select v-model="form.rank_id" id="rank_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="" disabled>Pilih pangkat</option>
                                                <option v-for="rank in ranks" :key="rank.id" :value="rank.id">{{ rank.rank_name }}</option>
                                            </select>
                                            <InputError :message="form.errors.rank_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="employee_status" value="Status Pegawai" />
                                            <select v-model="form.employee_status" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="" disabled>Pilih status</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Pensiun">Pensiun</option>
                                            </select>
                                            <InputError :message="form.errors.employee_status" />
                                        </div>
                                        <div>
                                            <InputLabel for="blood_group" value="Golongan Darah" />
                                            <select v-model="form.blood_group" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="" disabled>Pilih golongan darah</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                            <InputError :message="form.errors.blood_group" />
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
                        <TableHeaderCell>NOMOR PEGAWAI</TableHeaderCell>
                        <TableHeaderCell>NAMA</TableHeaderCell>
                        <TableHeaderCell>JABATAN</TableHeaderCell>
                        <TableHeaderCell>STATUS PEGAWAI</TableHeaderCell>
                        <TableHeaderCell>GOLONGAN DARAH</TableHeaderCell>
                        <TableHeaderCell>TANGGAL AWAL KERJA</TableHeaderCell>
                        <TableHeaderCell></TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow v-for="(data, index) in fetchData.data" :key="data.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <TableDataCell :status="'number'">{{ index+1 }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.employee_number }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.position_id[0].position_name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.employee_status }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.blood_group }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.tanggal_mulai_kerja }}</TableDataCell>
                        <TableDataCell :status="'action'">
                            <!-- Lihat Data  -->
                            <template v-if="hasPermission('employee: read')">
                                <button @click="modalLiatData(data)" class="text-white mr-1 bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Ubah Data  -->
                            <template v-if="hasPermission('employee: update')">
                                <button @click="modalUbahData(data)" class="text-white mr-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Hapus Data  -->
                            <template v-if="hasPermission('employee: delete')">
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
                                LIHAT PEGAWAI
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
                                                NOMOR PEGAWAI
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.employee_number }}
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
                                                JENIS KELAMIN
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.gender }}
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
                                                NOMOR TELEPON
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.phone }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                TANGGAL AWAL KERJA
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.effective_date }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                JABATAN
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.position_id[0]['position_name'] }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                PANGKAT
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.rank_id[0]['rank_name'] }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                STATUS PEGAWAI
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.employee_status }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                GOLONGAN DARAH
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.blood_group }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                PENDIDIKAN TERAKHIR
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ form.education_id[0]['education_name'] }}
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
                            <div class="px-4 py-2 grid grid-cols-2 gap-2">
                                <div>
                                    <InputLabel for="employee_number" value="Nomor Pegawai" />
                                    <TextInput
                                        id="employee_number"
                                        type="text"
                                        class="block w-full"
                                        v-model="form.employee_number"
                                    />
                                    <InputError :message="form.errors.employee_number" />
                                </div>
                                <div>
                                    <InputLabel for="name" value="Nama Lengkap" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="block w-full"
                                        v-model="form.name"
                                    />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div>
                                    <InputLabel for="gender" value="Jenis Kelamin" />
                                    <select v-model="form.gender" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled>Pilih jenis kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <InputError :message="form.errors.gender" />
                                </div>
                                <div>
                                    <InputLabel for="address" value="Alamat" />
                                    <TextInput
                                        id="address"
                                        type="text"
                                        class="block w-full"
                                        v-model="form.address"
                                    />
                                    <InputError :message="form.errors.address" />
                                </div>
                                <div>
                                    <InputLabel for="phone" value="Nomor Telepon" />
                                    <TextInput
                                        id="phone"
                                        type="text"
                                        class="block w-full"
                                        v-model="form.phone"
                                    />
                                    <InputError :message="form.errors.phone" />
                                </div>
                                <div>
                                    <InputLabel for="education_id" value="Pendidikan Terakhir" />
                                    <VueMultiselect
                                        v-model="form.education_id"
                                        :options="educations"
                                        :close-on-select="true"
                                        placeholder="Pilih pendidikan"
                                        label="education_name" track-by="id"
                                    />
                                    <InputError :message="form.errors.education_id" />
                                </div>
                                <div>
                                    <InputLabel for="effective_date" value="Tanggal Awal Kerja" />
                                    <TextInput
                                        id="effective_date"
                                        type="date"
                                        class="block w-full"
                                        v-model="form.effective_date"
                                    />
                                    <InputError :message="form.errors.effective_date" />
                                </div>
                                <div>
                                    <InputLabel for="position_id" value="Jabatan" />
                                    <select v-model="form.position_id" id="position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled>Pilih jabatan</option>
                                        <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.position_name }}</option>
                                    </select>
                                    <InputError :message="form.errors.position_id" />
                                </div>
                                <div>
                                    <InputLabel for="rank_id" value="Jabatan" />
                                    <select v-model="form.rank_id" id="rank_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled>Pilih jabatan</option>
                                        <option v-for="rank in ranks" :key="rank.id" :value="rank.id">{{ rank.rank_name }}</option>
                                    </select>
                                    <InputError :message="form.errors.rank_id" />
                                </div>
                                <div>
                                    <InputLabel for="employee_status" value="Status Pegawai" />
                                    <select v-model="form.employee_status" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled>Pilih status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Pensiun">Pensiun</option>
                                    </select>
                                    <InputError :message="form.errors.employee_status" />
                                </div>
                                <div>
                                    <InputLabel for="blood_group" value="Golongan Darah" />
                                    <select v-model="form.blood_group" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled>Pilih golongan darah</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                    <InputError :message="form.errors.blood_group" />
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
                                Apakah anda yakin ingin menghapus pegawai ini ?
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
