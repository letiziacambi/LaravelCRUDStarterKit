<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import CrudDelete from './CrudDelete.vue'
const props = defineProps({
  fields: {
    type: Array,
    default: new Array(),
  },
  actions: {
    type: Object,
    default: new Object(),
  },
  subject: {
    type: String,
    default: '',
  },
  data: {
    type: Object,
    default: new Object(),
  },
})

/* DATA */
const isLoadingTable = ref(false)
const searchVal = ref(null)

/* METHODS */
function loadItems({ page, itemsPerPage, sortBy, search }) {
  isLoadingTable.value = true
  var params = {
    page: page,
    limit: itemsPerPage,
    sort: sortBy[0],
  }
  if (search) {
    params.search = search
  }
  let form = useForm(params)

  form.get(`/${props.subject}`, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      isLoadingTable.value = false
    },
  })
}

function getHeaders() {
  let arr = []
  props.fields.forEach((el) => {
    arr.push({ title: el.name, key: el.name })
  })
  arr.push({ title: 'Action', key: 'action' })
  return arr
}
</script>

<template>
  <div>
    <v-card>
      <div class="d-flex flex-wrap align-center px-4 pb-4">
        <v-text-field
          v-model="searchVal"
          label="Search"
          variant="underlined"
          prepend-inner-icon="mdi-magnify"
          hide-details
          clearable
          single-line
        />
        <v-spacer />
        <Link v-if="actions['create']" :href="route(`${subject}.create`)" as="div">
          <v-btn color="primary">Create</v-btn>
        </Link>
      </div>
      <v-data-table-server
        :search="searchVal"
        :items="data.data"
        :items-length="data.total"
        :headers="getHeaders()"
        class="elevation-0"
        :loading="isLoadingTable"
        @update:options="loadItems"
      >
        <template #[`item.action`]="{ item }">
          <Link v-if="actions['update']" :href="`/${subject}/${item.id}/edit`" as="button">
            <v-icon color="primary" icon="mdi-pencil" size="small" />
          </Link>
          <CrudDelete v-if="actions['delete']" :item="item" :subject="subject" />
          <Link v-if="actions['show']" :href="`/${subject}/${item.id}`" as="button" class="ml-2">
            <v-icon color="primary" icon="mdi-eye" size="small" />
          </Link>
        </template>
      </v-data-table-server>
    </v-card>
  </div>
</template>
