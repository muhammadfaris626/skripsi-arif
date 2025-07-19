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

    const props = defineProps({
        requestNumber: {
            type: String
        },
        resident: {
            type: Object,
            required: true
        },
        works: Array,
        coverLetters: Array
    });

    const form = useForm({
        id: "",
        cover_letter_id: "",
        request_number: props.requestNumber,
        user_id: usePage().props.auth.user.id,
        resident_id: props.resident?.id,
        name: "",
        resident_number: "",
        place_of_birth: "",
        date_of_birth: "",
        gender: "",
        marital_status: "",
        religion: "",
        work_id: "",
        address: "",
        description: "",
        validity_period: "",
        created_at: "",
        updated_at: ""
    });

    const tambahData = () => {
        form.post(route('unmarried-certificates.store'), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
            }
        });
    }
</script>

<template>
    <Head title="Surat Keterangan Belum Menikah" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-1 h-full">
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
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <Link :href="route('unmarried-certificates.index')" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Surat Keterangan Belum Menikah</Link>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Tambah Surat Keterangan Belum Menikah</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="pt-4">
                <h1 class="text-2xl font-semibold text-blue-600">TAMBAH SURAT KETERANGAN BELUM MENIKAH</h1>
                <form action=""></form>
                <form @submit.prevent="tambahData">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <InputLabel for="cover_letter_id">
                                Nomor Surat Pengantar <span class="text-red-500">*</span>
                            </InputLabel>
                            <VueMultiselect
                                v-model="form.cover_letter_id"
                                :options="coverLetters"
                                :close-on-select="true"
                                placeholder="Pilih nomor surat pengantar"
                                label="request_number" track-by="id"
                            />
                            <InputError :message="form.errors.cover_letter_id" />
                        </div>
                        <div>
                            <InputLabel for="request_number">
                                Nomor Permintaan <span class="text-red-500">*</span>
                            </InputLabel>
                            <TextInput
                                id="request_number"
                                type="text"
                                class="block w-full bg-gray-300 font-bold"
                                v-model="form.request_number"
                                disabled
                            />
                            <InputError :message="form.errors.request_number" />
                        </div>
                        <div>
                            <InputLabel for="name">
                                Nama Lengkap <span class="text-red-500">*</span>
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
                            <InputLabel for="resident_number">
                                Nomor Induk Kependudukan <span class="text-red-500">*</span>
                            </InputLabel>
                            <TextInput
                                id="resident_number"
                                type="text"
                                class="block w-full"
                                v-model="form.resident_number"
                            />
                            <InputError :message="form.errors.resident_number" />
                        </div>
                        <div>
                            <InputLabel for="place_of_birth">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </InputLabel>
                            <TextInput
                                id="place_of_birth"
                                type="text"
                                class="block w-full"
                                v-model="form.place_of_birth"
                            />
                            <InputError :message="form.errors.place_of_birth" />
                        </div>
                        <div>
                            <InputLabel for="date_of_birth">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </InputLabel>
                            <TextInput
                                id="date_of_birth"
                                type="date"
                                class="block w-full"
                                v-model="form.date_of_birth"
                            />
                            <InputError :message="form.errors.date_of_birth" />
                        </div>
                        <div>
                            <InputLabel for="gender">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </InputLabel>
                            <select v-model="form.gender" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Pilih jenis kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <InputError :message="form.errors.gender" />
                        </div>
                        <div>
                            <InputLabel for="marital_status">
                                Status Perkawinan <span class="text-red-500">*</span>
                            </InputLabel>
                            <select v-model="form.marital_status" id="marital_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Pilih status perkawinan</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin Tercatat">Kawin Tercatat</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                            <InputError :message="form.errors.marital_status" />
                        </div>
                        <div>
                            <InputLabel for="religion">
                                Agama <span class="text-red-500">*</span>
                            </InputLabel>
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
                            <InputLabel for="work_id">
                                Pekerjaan <span class="text-red-500">*</span>
                            </InputLabel>
                            <VueMultiselect
                                v-model="form.work_id"
                                :options="works"
                                :close-on-select="true"
                                placeholder="Pilih pekerjaan"
                                label="work_name" track-by="id"
                            />
                            <InputError :message="form.errors.work_id" />
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
                        <div>
                            <InputLabel for="description">
                                Alasan Membuat Surat Keterangan <span class="text-red-500">*</span>
                            </InputLabel>
                            <TextInput
                                id="description"
                                type="text"
                                class="block w-full"
                                v-model="form.description"
                            />
                            <InputError :message="form.errors.description" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">TAMBAH</button>
                        <Link :href="route('unmarried-certificates.index')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">KEMBALI</Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
