<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { onMounted } from 'vue';
    import { usePage, useForm, router, Head, Link } from '@inertiajs/vue3';

    const props = defineProps({
        fetchData: {
            type: Object,
            required: true
        }
    })

    onMounted(() => {
        window.print();
    });
</script>

<template>
    <Head title="Surat Keterangan Usaha" />
    <div class="grid grid-cols-1 gap-4 p-4">
        <!-- {{ props.fetchData }} -->
        <div class="grid grid-cols-5 px-40 pt-24">
            <div>
                <img :src="'/images/logo-surat.png'" class="me-3" alt="FlowBite Logo" width="60%"/>
            </div>
            <div class="col-span-3">
                <p class="text-center text-2xl">PEMERINTAH KOTA MAKASSAR</p>
                <p class="text-center text-2xl">KECAMATAN BIRINGKANAYA</p>
                <p class="text-center font-bold text-2xl">KELURAHAN KATIMBANG</p>
                <p class="italic text-center">Jl. Keindahan Raya Poros BTP Blok AC Kesatuan Kota Makassar</p>
                <p class="italic text-center">Email : kelurahankatimbang27@gmail.com Makassar Kode Pos 90241</p>
            </div>
            <div>

            </div>
        </div>
        <div class="border-t-8 mx-24 border-black">
            <div class="border-t-2 mt-1 border-black">
                <p class="text-center underline font-bold text-xl mt-5">SURAT KETERANGAN DOMISILI</p>
                <p class="text-center">NOMOR: {{ props.fetchData.request_number }}</p>
                <p class="ml-10 text-lg">Yang bertanda tangan di bawah ini :</p>
                <div class="grid grid-cols-3">
                    <div class="ml-20 col-span-2 relative">
                        <table class="text-md text-left rtl:text-right">
                            <tbody>
                                <tr>
                                    <td scope="row" class="px-6">
                                        Nama
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.history[0].approver.employee[0].name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Jabatan
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.history[0].approver.position_name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="ml-10 text-lg">Dengan ini menerangkan bahwa :</p>
                <div class="grid grid-cols-3">
                    <div class="ml-20 col-span-2 relative">
                        <table class="text-md text-left rtl:text-right">
                            <tbody>
                                <tr>
                                    <td scope="row" class="px-6">
                                        Nama
                                    </td>
                                    <td class="px-6">
                                        : <b class="uppercase">{{ props.fetchData.user_id[0].name }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        NIK
                                    </td>
                                    <td class="px-6">
                                        <!-- : {{ props.fetchData.resident[0].resident_number }} -->
                                        : {{ props.fetchData.resident_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Tempat / Tanggal lahir
                                    </td>
                                    <td class="px-6">
                                        : {{ props.fetchData.place_of_birth }}, {{ new Date(props.fetchData.date_of_birth).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Jenis Kelamin
                                    </td>
                                    <td class="px-6">
                                        : {{ props.fetchData.gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Status Perkawinan
                                    </td>
                                    <td class="px-6">
                                        : {{ props.fetchData.marital_status }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Agama
                                    </td>
                                    <td class="px-6">
                                        : {{ props.fetchData.religion }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Pekerjaan
                                    </td>
                                    <td class="px-6">
                                        : {{ props.fetchData.work_id[0].work_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Alamat
                                    </td>
                                    <td class="px-6">
                                        : {{ props.fetchData.address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Masa Berlaku
                                    </td>
                                    <td class="px-6">
                                        : <b>{{ new Date(props.fetchData.validity_period).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="mx-10 text-lg text-justify">
                    Yang tersebut namanya di atas adalah penduduk Kelurahan Katimbang Kecamatan Biringkanaya
                    Kota Makassar dan berdomisili Tetap pada alamat tersebut di atas sesuai pengantar Nomor <b>{{ props.fetchData.request_number }}</b>
                    pada tanggal {{ new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}.
                </p>
                <p class="ml-10 text-lg text-justify">
                    Dengan surat keterangan ini diberikan dan dipergunakan <b>sebagaimana mestinya</b>.
                </p>
                <div v-if="props.fetchData.history.length == 1" class="grid grid-cols-3 mt-10">
                    <div v-for="data in props.fetchData.history" :key="data.id" class="col-start-3">
                        <p class="text-lg">Makassar, {{ new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                        <p class="text-lg font-bold">{{ data.approver.position_name }}</p>
                        <p class="text-lg font-bold underline mt-24">{{ data.approver.employee[0].name }}</p>
                        <p class="text-lg">Pangkat: {{ data.approver.employee[0].rank.rank_name }}</p>
                        <p>NIP : {{ data.approver.employee[0].employee_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
