<script>
export default { name: 'CRUDEdit' }
</script>

<script setup>
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
  fields: {
    type: Array,
  },
  breadcrumbs: {
    type: Array,
  },
  entity: {
    type: String,
  },
  subject: {
    type: String,
  },
  item: {
    type: Object,
  },
})
</script>

<template>
  <Head :title="`Show ${entity}`" />
  <div class="mb-5">
    <h5 class="text-h5 font-weight-bold">Show {{ entity }}</h5>
    <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />
  </div>
  <v-btn color="primary" class="mb-2" text @click="router.visit(route(`${subject}.index`))"> Back </v-btn>
  <v-card>
    <v-table density="compact">
      <thead>
        <tr>
          <th class="text-left">Field</th>
          <th class="text-left">Value</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="field in fields" :key="field.field">
          <td>{{ field.name }}</td>
          <td>{{ item[field.field] }}</td>
        </tr>
      </tbody>
    </v-table>
  </v-card>
</template>
