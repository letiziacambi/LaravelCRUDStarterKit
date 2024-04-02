<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  item: {
    type: Object,
    default: new Object(),
  },
  subject: {
    type: String,
    default: '',
  },
})

/* DATA */
const deleteDialog = ref(false)
const isLoading = ref(false)

/* METHODS */
function submitDelete() {
  isLoading.value = true
  // eslint-disable-next-line no-undef
  axios.delete(route(`${props.subject}.destroy`, { [props.subject]: props.item }), {
    params: { [props.subject]: props.item },
    preserveState: true,
    preserveScroll: true,
    onFinish: () => {
      isLoading.value = false
      deleteDialog.value = false
    },
  })
}
</script>

<template>
  <v-icon class="ml-2" color="primary" icon="mdi-delete" size="small" @click="deleteDialog = true" />

  <v-row justify="center">
    <v-dialog v-model="deleteDialog" persistent width="auto">
      <v-card>
        <v-card-text>Are you sure you want to delete this item?</v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn text @click="deleteDialog = false">Cancel</v-btn>
          <v-btn color="primary" :loading="isLoading" text @click="submitDelete">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
