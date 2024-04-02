<script setup>
import { Link } from '@inertiajs/vue3'
import axios from 'axios'
import { ref } from 'vue'
import CrudDelete from './CrudDelete.vue'
const props = defineProps({
  subject: {
    type: String,
    default: '',
  },
  params: {
    type: Object,
    default: new Object(),
  },
})

/* DATA */
const isLoadingTable = ref(false)
const searchVal = ref(null)

const data = ref({})
const headers = ref([])
const actions = ref({})

/* METHODS */
async function loadInfo() {
  // eslint-disable-next-line no-undef
  await axios.get(`/api/${props.subject}/info`).then((res) => {
    headers.value = getHeaders(res.data.fields)
    actions.value = res.data.actions
  })
}

async function loadItems({ page = 0, itemsPerPage = 20, sortBy = ['id'], search = null }) {
  isLoadingTable.value = true
  var params = props.params
  params.page = page
  params.limit = itemsPerPage
  params.sort = sortBy[0]

  if (search) {
    params.search = search
  }

  await axios.get(`/api/${props.subject}`, { params: params }).then((res) => {
    data.value = res.data
    isLoadingTable.value = false
  })
}

loadInfo()
loadItems

function getHeaders(fields) {
  let arr = []
  fields.forEach((el) => {
    arr.push({ title: el.label, key: el.name })
  })
  arr.push({ title: 'Action', key: 'action' })
  return arr
}
</script>

<template>
  <div>
    <v-card v-if="data && headers && actions">
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
        :headers="headers"
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
