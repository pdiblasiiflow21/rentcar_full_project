<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Pagos</h2>

    <!-- FORM -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <h3 class="font-semibold mb-2">Nuevo Pago</h3>

      <select v-model="form.rental_id" class="border p-2 w-full mb-2">
        <option disabled value="">Seleccionar alquiler</option>
        <option v-for="r in rentals" :key="r.id" :value="r.id">
          {{ r.driver.name }} - {{ r.vehicle.plate }}
        </option>
      </select>

      <select v-model="form.rental_id" class="border p-2 w-full mb-2" @change="getDebt(form.rental_id)">
        <option disabled value="">Seleccionar deuda</option>
      </select>

      <input v-model="form.amount" placeholder="Monto" class="border p-2 w-full mb-2"/>
      <input v-model="form.km_reported" placeholder="KM actual" class="border p-2 w-full mb-2"/>
      
      <button @click="save" class="bg-green-500 text-white px-4 py-2 rounded">
        Guardar
      </button>
    </div>

    <!-- TABLA -->
    <table class="w-full bg-white shadow rounded">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2">Fecha</th>
          <th class="p-2">Conductor</th>
          <th class="p-2">Vehículo</th>
          <th class="p-2">Monto</th>
          <th class="p-2">KM</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="p in payments" :key="p.id" class="border-t">
          <td class="p-2">{{ p.payment_date }}</td>
          <td class="p-2">{{ p.rental.driver.name }}</td>
          <td class="p-2">{{ p.rental.vehicle.plate }}</td>
          <td class="p-2">${{ p.amount }}</td>
          <td class="p-2">{{ p.km_reported }}</td>
        </tr>
      </tbody>
    </table>

  </div>

  <!-- DEUDA -->
  <div v-if="debt" class="bg-yellow-100 p-4 rounded mb-4">
  <p>Esperado: ${{ debt.expected }}</p>
  <p>Pagado: ${{ debt.paid }}</p>
  <p class="font-bold">Deuda: ${{ debt.debt }}</p>
</div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/axios';

const payments = ref([]);
const rentals = ref([]);

const form = ref({
  rental_id: '',
  amount: '',
  km_reported: ''
});

// cargar datos
const load = async () => {
  const p = await api.get('/payments');
  const r = await api.get('/rentals');

  payments.value = p.data;
  rentals.value = r.data;
};

// guardar
const save = async () => {
  await api.post('/payments', {
    ...form.value,
    payment_date: new Date().toISOString().slice(0,10)
  });

  form.value = { rental_id: '', amount: '', km_reported: '' };
  load();
};

onMounted(load);

// mostrar deuda al seleccionar alquiler
const debt = ref(null);

const getDebt = async (rentalId) => {
  const res = await api.get(`/rentals/${rentalId}/debt`);
  debt.value = res.data;
};

</script>

