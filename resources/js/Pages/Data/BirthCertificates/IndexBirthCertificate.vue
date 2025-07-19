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
    defineProps(["fetchData", 'familyCards']);
    const form = useForm({
        id: "",
        name: "",
        gender: "",
        religion: "",
        place_of_birth: "",
        date_of_birth: "",
        time_of_birth: "",
        family_card_id: "",
        father_name: "",
        mother_name: "",
        address: "",
        child_from: "",
        give_birth_in: "",
        birth_location: "",
        weight: "",
        birth_certificate: "",
        created_at: "",
        updated_at: ""
    });
    const { hasPermission } = usePermission();
    let search = ref(usePage().props.search), pageNumber = ref(1);
    let searchUrl = computed(() => {
        let url = new URL(route('birthCertificates.index'));
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
        form.name = data.name;
        form.gender = data.gender;
        form.religion = data.religion;
        form.place_of_birth = data.place_of_birth;
        form.date_of_birth = data.date_of_birth;
        form.time_of_birth = data.time_of_birth;
        form.family_card_id = data.family_card_id[0].family_number;
        form.father_name = data.father_name;
        form.mother_name = data.mother_name;
        form.address = data.address;
        form.child_from = data.child_from;
        form.give_birth_in = data.give_birth_in;
        form.birth_location = data.birth_location;
        form.weight = data.weight;
        form.birth_certificate = data.birth_certificate;
        form.created_at = data.created_at;
        form.updated_at = data.updated_at;
    }

    const modalUbahData = (data) => {
        showModalUpdate.value = true;
        form.id = data.id;
        form.name = data.name;
        form.gender = data.gender;
        form.religion = data.religion;
        form.place_of_birth = data.place_of_birth;
        form.date_of_birth = data.date_of_birth;
        form.time_of_birth = data.time_of_birth;
        form.family_card_id = data.family_card_id;
        form.father_name = data.father_name;
        form.mother_name = data.mother_name;
        form.address = data.address;
        form.child_from = data.child_from;
        form.give_birth_in = data.give_birth_in;
        form.birth_location = data.birth_location;
        form.weight = data.weight;
        form.birth_certificate = data.birth_certificate;
    }
    const modalHapusData = (data) => {
        showModalDelete.value = true;
        form.id = data.id;
    }

    const tambahData = () => {
        form.post(route('birthCertificates.store'), {
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
        form.put(route('birthCertificates.update', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalUpdate.value = false;
            }
        });
    }
    const hapusData = () => {
        form.delete(route('birthCertificates.destroy', form.id), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                showModalDelete.value = false;
            }
        });
    }

</script>

<template>
    <Head title="Akte Kelahiran" />
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
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Akte Kelahiran</span>
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
                    <template v-if="hasPermission('birth-certificate: create')">
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
                                        TAMBAH AKTE KELAHIRAN
                                    </h3>
                                </div>
                                <form @submit.prevent="tambahData">
                                    <div class="px-4 py-2 grid grid-cols-2 gap-2 mb-2">
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
                                            <InputLabel for="religion" value="Agama" />
                                            <select v-model="form.religion" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="" disabled>Pilih agama</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Budha">Budha</option>
                                                <option value="Khonghucu">Khonghucu</option>
                                            </select>
                                            <InputError :message="form.errors.religion" />
                                        </div>
                                        <div>
                                            <InputLabel for="place_of_birth" value="Tempat Lahir" />
                                            <TextInput
                                                id="place_of_birth"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.place_of_birth"
                                            />
                                            <InputError :message="form.errors.place_of_birth" />
                                        </div>
                                        <div>
                                            <InputLabel for="date_of_birth" value="Tanggal Lahir" />
                                            <TextInput
                                                id="date_of_birth"
                                                type="date"
                                                class="block w-full"
                                                v-model="form.date_of_birth"
                                            />
                                            <InputError :message="form.errors.date_of_birth" />
                                        </div>
                                        <div>
                                            <InputLabel for="time_of_birth" value="Jam Lahir" />
                                            <TextInput
                                                id="time_of_birth"
                                                type="time"
                                                class="block w-full"
                                                v-model="form.time_of_birth"
                                            />
                                            <InputError :message="form.errors.time_of_birth" />
                                        </div>
                                        <div>
                                            <InputLabel for="family_card_id" value="Nomor Kartu Keluarga" />
                                            <VueMultiselect
                                                v-model="form.family_card_id"
                                                :options="familyCards"
                                                :close-on-select="true"
                                                placeholder="Pilih kartu keluarga"
                                                label="family_number" track-by="id"
                                            />
                                            <InputError :message="form.errors.family_card_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="father_name" value="Nama Ayah" />
                                            <TextInput
                                                id="father_name"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.father_name"
                                            />
                                            <InputError :message="form.errors.father_name" />
                                        </div>
                                        <div>
                                            <InputLabel for="mother_name" value="Nama Ibu" />
                                            <TextInput
                                                id="mother_name"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.mother_name"
                                            />
                                            <InputError :message="form.errors.mother_name" />
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
                                            <InputLabel for="child_from" value="Anak Ke" />
                                            <TextInput
                                                id="child_from"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.child_from"
                                            />
                                            <InputError :message="form.errors.child_from" />
                                        </div>
                                        <div>
                                            <InputLabel for="give_birth_in" value="Dilahirkan Di" />
                                            <TextInput
                                                id="give_birth_in"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.give_birth_in"
                                            />
                                            <InputError :message="form.errors.give_birth_in" />
                                        </div>
                                        <div>
                                            <InputLabel for="birth_location" value="Tempat Dilahirkan" />
                                            <TextInput
                                                id="birth_location"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.birth_location"
                                            />
                                            <InputError :message="form.errors.birth_location" />
                                        </div>
                                        <div>
                                            <InputLabel for="weight" value="Berat Badan" />
                                            <TextInput
                                                id="weight"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.weight"
                                            />
                                            <InputError :message="form.errors.weight" />
                                        </div>
                                        <div>
                                            <InputLabel for="birth_certificate" value="Nomor Surat Kelahiran" />
                                            <TextInput
                                                id="birth_certificate"
                                                type="text"
                                                class="block w-full"
                                                v-model="form.birth_certificate"
                                            />
                                            <InputError :message="form.errors.birth_certificate" />
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
                        <TableHeaderCell>AGAMA</TableHeaderCell>
                        <TableHeaderCell>TTL</TableHeaderCell>
                        <TableHeaderCell>NAMA AYAH</TableHeaderCell>
                        <TableHeaderCell>NAMA IBU</TableHeaderCell>
                        <TableHeaderCell>ANAK KE</TableHeaderCell>
                        <TableHeaderCell></TableHeaderCell>
                    </TableRow>
                </template>
                <template #default>
                    <TableRow v-for="(data, index) in fetchData.data" :key="data.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <TableDataCell :status="'number'">{{ index+1 }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.family_card_id[0].family_number }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.religion }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.place_of_birth }}, {{ data.date_of_birth }} {{ data.time_of_birth }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.father_name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.mother_name }}</TableDataCell>
                        <TableDataCell :status="'record'">{{ data.child_from }}</TableDataCell>
                        <TableDataCell :status="'action'">
                            <!-- Lihat Data  -->
                            <template v-if="hasPermission('birth-certificate: read')">
                                <button @click="modalLiatData(data)" class="text-white mr-1 bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Ubah Data  -->
                            <template v-if="hasPermission('birth-certificate: update')">
                                <button @click="modalUbahData(data)" class="text-white mr-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                            </template>
                            <!-- Hapus Data  -->
                            <template v-if="hasPermission('birth-certificate: delete')">
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
                            LIHAT AKTE KELAHIRAN
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
                                            {{ form.family_card_id }}
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
                                            AGAMA
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.religion }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            TEMPAT, TANGGAL LAHIR
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.place_of_birth }}, {{ form.date_of_birth }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            JAM LAHIR
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.time_of_birth }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NAMA AYAH
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.father_name }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NAMA IBU
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.mother_name }}
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
                                            ANAK KE
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.child_from }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            DILAHIRKAN DI
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.give_birth_in }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            TEMPAT DILAHIRKAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.birth_location }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            BERAT BADAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.weight }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            NOMOR SURAT KELAHIRAN
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ form.birth_certificate }}
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
                            UBAH AKTE KELAHIRAN
                        </h3>
                    </div>
                    <form @submit.prevent="ubahData">
                        <div class="px-4 py-2 grid grid-cols-2 gap-2 mb-2">
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
                                <InputLabel for="religion" value="Agama" />
                                <select v-model="form.religion" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled>Pilih agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen Protestan">Kristen Protestan</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                                <InputError :message="form.errors.religion" />
                            </div>
                            <div>
                                <InputLabel for="place_of_birth" value="Tempat Lahir" />
                                <TextInput
                                    id="place_of_birth"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.place_of_birth"
                                />
                                <InputError :message="form.errors.place_of_birth" />
                            </div>
                            <div>
                                <InputLabel for="date_of_birth" value="Tanggal Lahir" />
                                <TextInput
                                    id="date_of_birth"
                                    type="date"
                                    class="block w-full"
                                    v-model="form.date_of_birth"
                                />
                                <InputError :message="form.errors.date_of_birth" />
                            </div>
                            <div>
                                <InputLabel for="time_of_birth" value="Jam Lahir" />
                                <TextInput
                                    id="time_of_birth"
                                    type="time"
                                    class="block w-full"
                                    v-model="form.time_of_birth"
                                />
                                <InputError :message="form.errors.time_of_birth" />
                            </div>
                            <div>
                                <InputLabel for="family_card_id" value="Nomor Kartu Keluarga" />
                                <VueMultiselect
                                    v-model="form.family_card_id"
                                    :options="familyCards"
                                    :close-on-select="true"
                                    placeholder="Pilih kartu keluarga"
                                    label="family_number" track-by="id"
                                />
                                <InputError :message="form.errors.family_card_id" />
                            </div>
                            <div>
                                <InputLabel for="father_name" value="Nama Ayah" />
                                <TextInput
                                    id="father_name"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.father_name"
                                />
                                <InputError :message="form.errors.father_name" />
                            </div>
                            <div>
                                <InputLabel for="mother_name" value="Nama Ibu" />
                                <TextInput
                                    id="mother_name"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.mother_name"
                                />
                                <InputError :message="form.errors.mother_name" />
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
                                <InputLabel for="child_from" value="Anak Ke" />
                                <TextInput
                                    id="child_from"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.child_from"
                                />
                                <InputError :message="form.errors.child_from" />
                            </div>
                            <div>
                                <InputLabel for="give_birth_in" value="Dilahirkan Di" />
                                <TextInput
                                    id="give_birth_in"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.give_birth_in"
                                />
                                <InputError :message="form.errors.give_birth_in" />
                            </div>
                            <div>
                                <InputLabel for="birth_location" value="Tempat Dilahirkan" />
                                <TextInput
                                    id="birth_location"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.birth_location"
                                />
                                <InputError :message="form.errors.birth_location" />
                            </div>
                            <div>
                                <InputLabel for="weight" value="Berat Badan" />
                                <TextInput
                                    id="weight"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.weight"
                                />
                                <InputError :message="form.errors.weight" />
                            </div>
                            <div>
                                <InputLabel for="birth_certificate" value="Nomor Surat Kelahiran" />
                                <TextInput
                                    id="birth_certificate"
                                    type="text"
                                    class="block w-full"
                                    v-model="form.birth_certificate"
                                />
                                <InputError :message="form.errors.birth_certificate" />
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
                            Apakah anda yakin ingin menghapus data akte kelahiran ini ?
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
