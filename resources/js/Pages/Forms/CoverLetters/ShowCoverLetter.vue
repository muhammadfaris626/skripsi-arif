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
        <div class="grid grid-cols-5 px-40 pt-24">
            <div>
                <img :src="'/images/logo-surat.png'" class="me-3" alt="FlowBite Logo" width="60%"/>
            </div>
            <div class="col-span-3">
                <p class="text-center text-2xl">PEMERINTAH KOTA MAKASSAR</p>
                <p class="text-center text-2xl">KECAMATAN BIRINGKANAYA</p>
                <p class="text-center font-bold text-2xl">KELURAHAN KATIMBANG</p>
                <p class="text-center text-2xl">ORGANISASI STRUKTUR RUKUN TETANGGA ORT {{ props.fetchData.resident_id[0].family_card_id[0].rt }} - ORW {{ props.fetchData.resident_id[0].family_card_id[0].rw }}</p>
                <p class="italic text-center">Alamat: Jl. Keberkahan 25 Blok AD No. 119 J BTP - HP/WA 085247925959</p>
            </div>
            <div>
            </div>
        </div>
        <div class="border-t-8 mx-24 border-black">
            <div class="border-t-2 mt-1 border-black">
                <p class="text-center underline font-bold text-xl mt-5">SURAT PENGANTAR</p>
                <p class="text-center">NOMOR: {{ props.fetchData.request_number }}</p>
                <p class="ml-10 text-lg">Yang bertanda tangan di bawah ini Ketua ORT {{ props.fetchData.resident_id[0].family_card_id[0].rt }} - ORW {{ props.fetchData.resident_id[0].family_card_id[0].rw }} Kelurahan Katimbang Kecamatan Biringkanaya Kota Makassar, menerangkan bahwa :</p>
                <div class="grid grid-cols-3">
                    <div class="ml-20 col-span-2 relative">
                        <table class="text-md text-left rtl:text-right">
                            <tbody>
                                <tr>
                                    <td scope="row" class="px-6">
                                        Nama Lengkap
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Tempat, Tanggal Lahir
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.place_of_birth }}, {{ new Date(props.fetchData.date_of_birth).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Jenis Kelamin
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.gender }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Agama
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.religion }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Pekerjaan
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.work_id[0].work_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        Alamat
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="px-6 ">
                                        NIK / NO. KK
                                    </td>
                                    <td class="px-6 uppercase">
                                        : {{ props.fetchData.resident_number }} / {{ props.fetchData.family_number }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="ml-10 text-lg">BENAR, yang tercantum namanya di atas adalah warga ORT {{ props.fetchData.resident_id[0].family_card_id[0].rt }} - ORW {{ props.fetchData.resident_id[0].family_card_id[0].rw }} Kelurahan Katimbang dan diberikan Surat Pengantar untuk keperluan Pengurusan <b>{{ props.fetchData.certificate_category_id[0].certificate_category_name }}</b>.</p>

                <p class="mx-10 text-lg text-justify">
                    Dengan surat pengantar ini dibuat untuk dipergunakan sebagaimana mestinya.
                </p>
                <div v-if="props.fetchData.history.length == 2" class="grid grid-cols-2 mt-10 text-center">
                    <div v-for="data in props.fetchData.history" :key="data.id">
                        <p v-if="data.step == props.fetchData.history.length" class="text-lg">Makassar, {{ new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                        <p v-else class="text-lg">&nbsp;</p>
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
