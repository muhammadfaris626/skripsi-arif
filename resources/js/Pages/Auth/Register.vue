<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
defineProps(['educations', 'works']);

const isKkChecked = ref(false);
const isKkValid = ref(false);
const isCheckingKk = ref(false);
const kkCheckMessage = ref('');
const response = ref(null);

const form = useForm({
    no_kk: '',
    nama_lengkap: '',
    nik: '',
    gender: '',
    education_id: '',
    work_id: '',
    place_of_birth: '',
    date_of_birth: '',
    wedding_date: '',
    paspor_number: '',
    kitap_number: '',
    father_name: '',
    mother_name: '',
    phone_number: '',
    religion: '',
    blood_group: '',
    marital_status: '',
    relationship_status: '',
    citizenship: '',
    email: '',
    password: ''
});

const onKkChange = () => {
    isKkChecked.value = false;
    isKkValid.value = false;
    kkCheckMessage.value = '';
};

const cekKartuKeluarga = async () => {
    try {
        const res = await axios.post('api/cek-kartu-keluarga', {
            no_kk: form.no_kk
        });
        if (res.data.status == 'sukses') {
            isKkValid.value = true;
            isKkChecked.value = true;
            kkCheckMessage.value = "Nomor Kartu Keluarga ditemukan. Anda dapat melanjutkan pendaftaran.";
        } else {
            isKkValid.value = false;
            isKkChecked.value = true;
            kkCheckMessage.value = "Nomor Kartu Keluarga tidak ditemukan. Silakan periksa kembali nomor yang Anda masukkan.";
        }
    } catch (err) {
        err.value = err.response?.data?.message || 'Terjadi kesalahan';
        console.error('Error:', err);
    }
}

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/" class="flex flex-col items-center justify-center text-center">
                <img :src="'/images/logo-surat.png'" class="w-20 mb-2" alt="FlowBite Logo" />
                <p class="text-xl font-semibold">
                    SIAK KELURAHAN KATIMBANG
                </p>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-5xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <Head title="Register" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-3 gap-4">
                    <!-- Nomor KK dengan tombol cek -->
                    <div class="col-span-3">
                        <InputLabel for="no_kk">
                            Nomor Kartu Keluarga <span class="text-red-500">*</span>
                        </InputLabel>
                        <div class="flex gap-2 mt-1">
                            <TextInput
                                id="no_kk"
                                type="text"
                                class="flex-1"
                                v-model="form.no_kk"
                                @input="onKkChange"
                                placeholder="Masukkan 16 digit nomor KK"
                            />
                            <button
                                type="button"
                                @click="cekKartuKeluarga"
                                :disabled="isCheckingKk || !form.no_kk.trim()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 whitespace-nowrap"
                            >
                                <svg v-if="isCheckingKk" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ isCheckingKk ? 'Mengecek...' : 'Cek KK' }}
                            </button>
                        </div>

                        <!-- Pesan hasil pengecekan -->
                        <div v-if="kkCheckMessage" class="mt-2">
                            <p :class="{
                                'text-green-600': isKkValid,
                                'text-red-600': !isKkValid,
                                'text-blue-600': !isKkChecked
                            }" class="text-sm">
                                {{ kkCheckMessage }}
                            </p>
                        </div>

                        <InputError class="mt-2" :message="form.errors.no_kk" />
                    </div>

                    <!-- Fields lainnya - disable jika KK belum valid -->
                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="nama_lengkap">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="nama_lengkap"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nama_lengkap"
                            :disabled="!isKkValid"
                        />
                        <InputError class="mt-2" :message="form.errors.nama_lengkap" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="nik">
                            Nomor Induk Kependudukan <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="nik"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nik"
                            :disabled="!isKkValid"
                        />
                        <InputError class="mt-2" :message="form.errors.nik" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="gender">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <InputError :message="form.errors.gender" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="place_of_birth">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="place_of_birth"
                            type="text"
                            class="block w-full"
                            v-model="form.place_of_birth"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.place_of_birth" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="date_of_birth">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="date_of_birth"
                            type="date"
                            class="block w-full"
                            v-model="form.date_of_birth"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.date_of_birth" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="religion">
                            Agama <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.religion" id="religion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
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

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="education">
                            Pendidikan <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.education_id" id="education" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih pendidikan</option>
                            <option
                                v-for="education in educations"
                                :key="education.id"
                                :value="education.id"
                            >
                                {{ education.education_name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.education_id" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="work">
                            Pekerjaan <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.work_id" id="work" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih pekerjaan</option>
                            <option
                                v-for="work in works"
                                :key="work.id"
                                :value="work.id"
                            >
                                {{ work.work_name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.work_id" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="blood_group">
                            Golongan Darah <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.blood_group" id="blood_group" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih golongan darah</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                        <InputError :message="form.errors.blood_group" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="marital_status">
                            Status Perkawinan <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.marital_status" id="marital_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih status perkawinan</option>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin Tercatat">Kawin Tercatat</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                        <InputError :message="form.errors.marital_status" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="wedding_date">
                            Tanggal Perkawinan <span class="text-red-500">(Tidak wajib diisi)</span>
                        </InputLabel>
                        <TextInput
                            id="wedding_date"
                            type="date"
                            class="block w-full"
                            v-model="form.wedding_date"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.wedding_date" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="relationship_status">
                            Status Dalam Keluarga <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.relationship_status" id="relationship_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih status dalam keluarga</option>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Menantu">Menantu</option>
                            <option value="Cucu">Cucu</option>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Mertua">Mertua</option>
                            <option value="Keluarga Lain">Keluarga Lain</option>
                            <option value="Pembantu">Pembantu</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <InputError :message="form.errors.relationship_status" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="citizenship">
                            Kewarganegaraan <span class="text-red-500">*</span>
                        </InputLabel>
                        <select v-model="form.citizenship" id="citizenship" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :disabled="!isKkValid">
                            <option value="" disabled>Pilih kewarganegaraan</option>
                            <option value="WNI">WNI</option>
                            <option value="WNA">WNA</option>
                        </select>
                        <InputError :message="form.errors.citizenship" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="paspor_number">
                            Nomor Paspor <span class="text-red-500">(Tidak wajib diisi)</span>
                        </InputLabel>
                        <TextInput
                            id="paspor_number"
                            type="text"
                            class="block w-full"
                            v-model="form.paspor_number"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.paspor_number" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="kitap_number">
                            Nomor Kitap <span class="text-red-500">(Tidak wajib diisi)</span>
                        </InputLabel>
                        <TextInput
                            id="kitap_number"
                            type="text"
                            class="block w-full"
                            v-model="form.kitap_number"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.kitap_number" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="father_name">
                            Nama Ayah <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="father_name"
                            type="text"
                            class="block w-full"
                            v-model="form.father_name"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.father_name" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="mother_name">
                            Nama Ibu <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="mother_name"
                            type="text"
                            class="block w-full"
                            v-model="form.mother_name"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.mother_name" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="phone_number">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="phone_number"
                            type="text"
                            class="block w-full"
                            v-model="form.phone_number"
                            :disabled="!isKkValid"
                        />
                        <InputError :message="form.errors.phone_number" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="email">
                            Email <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            :disabled="!isKkValid"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div :class="{ 'opacity-50 pointer-events-none': !isKkValid }">
                        <InputLabel for="password">
                            Password <span class="text-red-500">*</span>
                        </InputLabel>
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            :disabled="!isKkValid"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing || !isKkValid }"
                        :disabled="form.processing || !isKkValid"
                    >
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
