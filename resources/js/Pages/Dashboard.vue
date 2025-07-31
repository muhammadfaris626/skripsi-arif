<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="text-center">
            <p class="text-xl text-gray-400 dark:text-gray-500">PEGAWAI</p>
            <p class="text-2xl">{{ employees }}</p>
            </div>
        </div>
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="text-center">
            <p class="text-xl text-gray-400 dark:text-gray-500">KARTU KELUARGA</p>
            <p class="text-2xl">{{ familyCards }}</p>
            </div>
        </div>
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="text-center">
            <p class="text-xl text-gray-400 dark:text-gray-500">PENDUDUK</p>
            <p class="text-2xl">{{ residents }}</p>
            </div>
        </div>
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
            <div class="text-center">
            <p class="text-xl text-gray-400 dark:text-gray-500">AKTE KELAHIRAN</p>
            <p class="text-2xl">{{ birthCertificates }}</p>
            </div>
        </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Chart 1 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded p-4 w-full">
                <apexchart
                type="bar"
                height="300"
                :options="chartOptions"
                :series="series"
                />
            </div>

            <!-- Chart 2 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded p-4 w-full">
                <apexchart
                type="bar"
                height="300"
                :options="chartOptions2"
                :series="series2"
                />
            </div>
            <!-- Chart 3 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded p-4 w-full">
                <apexchart
                type="bar"
                height="300"
                :options="chartOptions3"
                :series="series3"
                />
            </div>
            <!-- Chart 4 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded p-4 w-full">
                <apexchart
                type="bar"
                height="300"
                :options="chartOptions4"
                :series="series4"
                />
            </div>
            <!-- Chart 5 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded p-4 w-full">
                <apexchart
                type="bar"
                height="300"
                :options="chartOptions5"
                :series="series5"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ApexChart from 'vue3-apexcharts'

// Props dari backend
const props = defineProps([
    'employees', 'familyCards', 'residents', 'birthCertificates',
    'suratPengantarData', 'suratDomisiliData', 'suratUsahaData',
    'suratBelumMenikahData', 'suratTidakMampuData'
])

// Chart 1 (Bar)
const chartOptions = ref({
    chart: {
        id: 'chart-bar',
        toolbar: { show: false }
    },
    title: {
        text: 'SURAT PENGANTAR',
        align: 'center',
        style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: { width: '100%' },
                legend: { position: 'bottom' }
            }
        }
    ]
})

const series = ref([
    {
        name: 'Total',
        data: props.suratPengantarData
    }
])

// Chart 2 (Line)
const chartOptions2 = ref({
    chart: {
        id: 'chart-bar',
        toolbar: { show: false }
    },
    title: {
        text: 'SURAT KETERANGAN DOMISILI',
        align: 'center',
        style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: { width: '100%' },
                legend: { position: 'bottom' }
            }
        }
    ]
})

const series2 = ref([
    {
        name: 'Total',
        data: props.suratDomisiliData
    }
])

// Chart 3 (Line)
const chartOptions3 = ref({
    chart: {
        id: 'chart-bar',
        toolbar: { show: false }
    },
    title: {
        text: 'SURAT KETERANGAN USAHA',
        align: 'center',
        style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: { width: '100%' },
                legend: { position: 'bottom' }
            }
        }
    ]
})

const series3 = ref([
    {
        name: 'Total',
        data: props.suratUsahaData
    }
])

// Chart 4 (Line)
const chartOptions4 = ref({
    chart: {
        id: 'chart-bar',
        toolbar: { show: false }
    },
    title: {
        text: 'SURAT KETERANGAN BELUM MENIKAH',
        align: 'center',
        style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: { width: '100%' },
                legend: { position: 'bottom' }
            }
        }
    ]
})

const series4 = ref([
    {
        name: 'Total',
        data: props.suratBelumMenikahData
    }
])

// Chart 5 (Line)
const chartOptions5 = ref({
    chart: {
        id: 'chart-bar',
        toolbar: { show: false }
    },
    title: {
        text: 'SURAT KETERANGAN TIDAK MAMPU',
        align: 'center',
        style: {
            fontSize: '11px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: { width: '100%' },
                legend: { position: 'bottom' }
            }
        }
    ]
})

const series5 = ref([
    {
        name: 'Total',
        data: props.suratTidakMampuData
    }
])
</script>

<script>
export default {
    components: {
        apexchart: ApexChart
    }
}
</script>
