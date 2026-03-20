<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">
    
    <form @submit.prevent="login" class="bg-white p-6 rounded shadow w-80">
      <h2 class="text-xl mb-4">Login</h2>

      <input v-model="email"
             placeholder="Email"
             class="border p-2 w-full mb-2"/>

      <input v-model="password"
             type="password"
             placeholder="Password"
             class="border p-2 w-full mb-4"/>

      <button class="bg-blue-500 text-white w-full py-2 rounded">
        Ingresar
      </button>

      <p v-if="error" class="text-red-500 mt-2">
        {{ error }}
      </p>
    </form>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const error = ref(null);

const auth = useAuthStore();
const router = useRouter();

const login = async () => {
    try {
        await auth.login({
            email: email.value,
            password: password.value
        });

        router.push('/');
    } catch (e) {
        error.value = 'Credenciales inválidas';
    }
};
</script>