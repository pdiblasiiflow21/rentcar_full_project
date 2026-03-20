<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Alta de Conductores</h1>

    <div class="bg-white p-4 rounded shadow mb-6">
      <form @submit.prevent="storeDriver" class="space-y-3">
        <div>
          <label class="block font-medium">Nombre</label>
          <input v-model="form.name" class="border rounded px-3 py-2 w-full" required />
        </div>
        <div>
          <label class="block font-medium">DNI</label>
          <input v-model="form.dni" class="border rounded px-3 py-2 w-full" />
        </div>
        <div>
          <label class="block font-medium">Número de licencia</label>
          <input v-model="form.license_number" class="border rounded px-3 py-2 w-full" />
        </div>
        <div>
          <label class="block font-medium">Vencimiento licencia</label>
          <input type="date" v-model="form.license_expiration" class="border rounded px-3 py-2 w-full" />
        </div>
        <div>
          <label class="block font-medium">Teléfono</label>
          <input v-model="form.phone" class="border rounded px-3 py-2 w-full" />
        </div>
        <div>
          <label class="block font-medium">Email</label>
          <input type="email" v-model="form.email" class="border rounded px-3 py-2 w-full" />
        </div>
        <div>
          <label class="block font-medium">Documentos (hasta 4 archivos, jpg/png/pdf)</label>
          <input type="file" ref="documentInput" multiple accept="image/*,.pdf" @change="onDocumentsChange" class="border rounded px-3 py-2 w-full" />
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar conductor</button>
      </form>

      <p class="text-sm mt-2 text-green-600" v-if="status">{{ status }}</p>
      <p class="text-sm mt-2 text-red-600" v-if="error">{{ error }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-xl font-semibold mb-3">Listado de conductores</h2>
      <table class="w-full text-left border-collapse border border-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Nombre</th>
            <th class="p-2 border">DNI</th>
            <th class="p-2 border">Licencia</th>
            <th class="p-2 border">Vencimiento</th>
            <th class="p-2 border">Teléfono</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Documentos</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="driver in drivers" :key="driver.id">
            <td class="p-2 border">{{ driver.id }}</td>
            <td class="p-2 border">{{ driver.name }}</td>
            <td class="p-2 border">{{ driver.dni || '-' }}</td>
            <td class="p-2 border">{{ driver.license_number || '-' }}</td>
            <td class="p-2 border">{{ driver.license_expiration || '-' }}</td>
            <td class="p-2 border">{{ driver.phone || '-' }}</td>
            <td class="p-2 border">{{ driver.email || '-' }}</td>
            <td class="p-2 border">
              <ul class="list-disc pl-5">
                <li v-for="doc in driver.documents || []" :key="doc"> <a :href="doc" target="_blank" class="text-blue-600 underline">Ver</a> </li>
              </ul>
            </td>
          </tr>
          <tr v-if="drivers.length === 0">
            <td class="p-2 border text-center" colspan="7">No hay conductores registrados.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/axios';

const drivers = ref([]);
const status = ref('');
const error = ref('');

const form = ref({
  name: '',
  dni: '',
  license_number: '',
  license_expiration: '',
  phone: '',
  email: '',
  documents: [],
});

const loadDrivers = async () => {
  try {
    const res = await api.get('/drivers');
    drivers.value = res.data;
  } catch (err) {
    error.value = 'No se pudo cargar la lista de conductores';
  }
};

const onDocumentsChange = (event) => {
  const files = Array.from(event.target.files || []);
  form.value.documents = files.slice(0, 4);
  if (files.length > 4) {
    error.value = 'Solo se permiten hasta 4 archivos.';
  } else {
    error.value = '';
  }
};

const storeDriver = async () => {
  try {
    error.value = '';
    status.value = '';

    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('dni', form.value.dni);
    formData.append('license_number', form.value.license_number);
    formData.append('license_expiration', form.value.license_expiration);
    formData.append('phone', form.value.phone);
    formData.append('email', form.value.email);

    if (form.value.documents.length > 0) {
      form.value.documents.slice(0, 4).forEach((file) => {
        formData.append('documents[]', file);
      });
    }

    const res = await api.post('/drivers', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });

    drivers.value.push(res.data);

    status.value = 'Conductor creado correctamente';
    form.value = {
      name: '',
      dni: '',
      license_number: '',
      license_expiration: '',
      phone: '',
      email: '',
      documents: [],
    };
    if (document.querySelector('input[type=file]')) {
      document.querySelector('input[type=file]').value = '';
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Error al crear conductor';
  }
};

onMounted(() => {
  loadDrivers();
});
</script>
