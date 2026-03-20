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