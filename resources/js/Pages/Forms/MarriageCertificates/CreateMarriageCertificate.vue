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
        works: Array
    });

    const form = useForm({
        id: "",
        request_number: props.requestNumber,
        user_id: "",
        name: "",
        place_of_birth: "",
        date_of_birth: "",
        work_id: "",
        couple_name: "",
        partner_address: "",
        guardian_name: "",
        wedding_date: "",
        name_of_the_chief: "",
        bride_price: "",
        witness_name: "",
        created_at: "",
        updated_at: "",
    });

    const tambahData = () => {
        form.work_id = form.work_id.id;
        form.post(route('marriage-certificates.store'), {
            onSuccess: () => {
                form.reset();
                form.clearErrors();
            }
        })
    }
</script>

<template>
    <Head title="Surat Keterangan Menikah" />
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
                                <Link :href="route('marriage-certificates.index')" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Surat Keterangan Menikah</Link>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Tambah Surat Keterangan Menikah</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="pt-4">
                <h1 class="text-2xl font-semibold text-blue-600">TAMBAH SURAT KETERANGAN MENIKAH</h1>
                <form @submit.prevent="tambahData">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <InputLabel for="request_number" value="Nomor Permintaan" />
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
                            <InputLabel for="name" value="Nama" />
                            <TextInput
                                id="name"
                                type="text"
                                class="block w-full"
                                v-model="form.name"
                            />
                            <InputError :message="form.errors.name" />
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
                            <InputLabel for="work_id" value="Pekerjaan" />
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
                            <InputLabel for="couple_name" value="Nama Pasangan" />
                            <TextInput
                                id="couple_name"
                                type="text"
                                class="block w-full"
                                v-model="form.couple_name"
                            />
                            <InputError :message="form.errors.couple_name" />
                        </div>
                        <div>
                            <InputLabel for="partner_address" value="Alamat Pasangan" />
                            <TextInput
                                id="partner_address"
                                type="text"
                                class="block w-full"
                                v-model="form.partner_address"
                            />
                            <InputError :message="form.errors.partner_address" />
                        </div>
                        <div>
                            <InputLabel for="guardian_name" value="Nama Wali" />
                            <TextInput
                                id="guardian_name"
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_name"
                            />
                            <InputError :message="form.errors.guardian_name" />
                        </div>
                        <div>
                            <InputLabel for="wedding_date" value="Tanggal Pernikahan" />
                            <TextInput
                                id="wedding_date"
                                type="date"
                                class="block w-full"
                                v-model="form.wedding_date"
                            />
                            <InputError :message="form.errors.wedding_date" />
                        </div>
                        <div>
                            <InputLabel for="name_of_the_chief" value="Nama Penghulu" />
                            <TextInput
                                id="name_of_the_chief"
                                type="text"
                                class="block w-full"
                                v-model="form.name_of_the_chief"
                            />
                            <InputError :message="form.errors.name_of_the_chief" />
                        </div>
                        <div>
                            <InputLabel for="bride_price" value="Mahar" />
                            <TextInput
                                id="bride_price"
                                type="text"
                                class="block w-full"
                                v-model="form.bride_price"
                            />
                            <InputError :message="form.errors.bride_price" />
                        </div>
                        <div>
                            <InputLabel for="witness_name" value="Nama Saksi" />
                            <TextInput
                                id="witness_name"
                                type="text"
                                class="block w-full"
                                v-model="form.witness_name"
                            />
                            <InputError :message="form.errors.witness_name" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">TAMBAH</button>
                        <Link :href="route('marriage-certificates.index')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">KEMBALI</Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
