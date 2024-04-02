<script>
export default { name: 'CRUDIndex' }
</script>

<script setup>
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { Head } from '@inertiajs/vue3'
import CrudList from '@/Components/CrudList.vue'

defineProps({
  data: {
    type: Object,
    default: new Object(),
  },
  fields: {
    type: Array,
  },
  actions: {
    type: Object,
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
})
</script>

<template>
  <Head :title="entity" />
  <div class="mb-5">
    <h5 class="text-h5 font-weight-bold">{{ entity }}</h5>
    <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />
  </div>
  <CrudList :data="data" :fields="fields" :actions="actions" :subject="subject" />
</template>
