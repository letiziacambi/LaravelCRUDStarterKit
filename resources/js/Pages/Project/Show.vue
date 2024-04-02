<script>
export default { name: 'CRUDEdit' }
</script>

<script setup>
import { ref } from 'vue'
import CrudListAjax from '@/Components/CrudListAjax.vue'

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

const selectedContent = ref('credentials')
const selectedSubject = ref('credential')
</script>

<template>
  <v-navigation-drawer>
    <v-list density="compact">
      <v-list-item
        title="Todo"
        :class="selectedContent == 'todos' ? 'bg-yellow' : ''"
        @click=";[(selectedContent = 'todos'), (selectedSubject = 'todo')]"
      />

      <v-list-item
        title="Credenziali"
        :class="selectedContent == 'credentials' ? 'bg-yellow' : ''"
        @click=";[(selectedContent = 'credentials'), (selectedSubject = 'credential')]"
      />
    </v-list>
  </v-navigation-drawer>
  <v-card>
    {{ item[selectedContent] }}
    {{ selectedSubject }}

    <CrudListAjax
      :key="selectedContent"
      :actions="['create', 'update', 'delete']"
      :subject="selectedSubject"
      :params="{ fields: { project_id: item.id } }"
    />
  </v-card>
</template>
