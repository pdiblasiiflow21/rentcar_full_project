<script setup>
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
auth.fetchUser();
</script>

<template>
  <h1>Bienvenido {{ auth.user?.name }}</h1>
</template>