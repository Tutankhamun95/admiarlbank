<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({

    accountNumber: {
        type: String,
    },
    accountName: {
        type: String
    },
    accountBalance: {
        type: String
    },
    lastModified: {
        type: String
    }

});

const deposit = () => {
    router.visit('deposit');
}

const transfer = () => {
    router.visit('transfer');
}

const viewTransactions = () => {
    router.visit('transactions');
}
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold mb-2">Account Details</h3>
                            <div class="flex justify-between items-center mb-4">
                                <div class="text-gray-700">
                                    <p class="font-semibold">Account Number:</p>
                                    <p>{{ accountNumber }}</p>
                                </div>
                                <div class="text-gray-700">
                                    <p class="font-semibold">Account Name:</p>
                                    <p>{{ accountName }}</p>
                                </div>
                                <div class="text-gray-700">
                                    <p class="font-semibold">Balance:</p>
                                    <p>{{ accountBalance }}</p>
                                </div>
                            </div>
                            <div class="text-gray-500">
                                <p class="font-semibold">Last Modified:</p>
                                <p>{{ lastModified }}</p>
                            </div>
                        </div>

                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <button @click="deposit"
                                    class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                    Deposit Money
                                </button>
                            </div>
                            <div class="mb-4">
                                <button @click="transfer"
                                    class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                    Transfer Money
                                </button>
                            </div>
                            <div class="mb-4">
                                <button @click="viewTransactions"
                                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                    View Transactions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>