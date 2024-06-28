<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  accountBalance: {
    type: String,
    required: true
  }
});

const form = useForm({
  amount: '',
});

const submit = () => {
  form.post('/store', {
    onSuccess: () => {
      // handle success
      console.log('Deposit successful!');
    },
    onError: (errors) => {
      // handle validation errors
      console.error(errors);
    },
  });
};

</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deposit</h2>
    </template>

    <div class="py-12 flex items-center justify-center">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 mx-auto">
              Current Balance: {{ accountBalance }}
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 mx-auto">
              <h2 class="text-2xl font-bold mb-4">Deposit Money</h2>
              <form @submit.prevent="submit">
                <div class="mb-4">
                  <label class="block text-gray-700">Amount</label>
                  <input v-model="form.amount" type="number" step="0.01" class="w-full px-4 py-2 border rounded-lg" />
                </div>
                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-700">
                  Deposit
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
