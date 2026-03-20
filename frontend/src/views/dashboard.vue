<!-- <script setup>
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
auth.fetchUser();
</script>

<template>
  <h1>Bienvenido {{ auth.user?.name }}</h1>
  <h1>dashboard.vue</h1>
</template> -->

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold">
      Bienvenido {{ auth.user?.name }}
    </h1>

    <p class="text-gray-500 mt-2">
      Sistema de alquiler de vehículos
    </p>

    <div class="mt-4 space-x-3">
      <router-link to="/drivers" class="text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Conductores</router-link>
      <router-link to="/vehicles" class="text-white bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-700">Vehículos</router-link>
      <router-link to="/rentals" class="text-white bg-purple-600 px-4 py-2 rounded hover:bg-purple-700">Alquileres</router-link>
      <router-link to="/payments" class="text-white bg-green-600 px-4 py-2 rounded hover:bg-green-700">Pagos</router-link>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();

onMounted(() => {
    if (!auth.user) {
        auth.fetchUser();
    }
});
</script>