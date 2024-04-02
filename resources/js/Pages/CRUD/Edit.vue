<script>
export default { name: 'CRUDEdit' }
</script>

<script setup>
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import CrudForm from '@/Components/CrudForm.vue'
import { Head } from '@inertiajs/vue3'

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
  <Head :title="`Edit ${entity}`" />
  <div class="mb-5">
    <h5 class="text-h5 font-weight-bold">Create {{ entity }}</h5>
    <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />
  </div>
  <CrudForm :fields="fields" :subject="subject" :item="item" />
</template>
