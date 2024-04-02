<script setup>
import { ref } from 'vue'
import { Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  fields: {
    type: Array,
  },
  subject: {
    type: String,
  },
  item: {
    type: Object,
    default: null,
  },
})

// eslint-disable-next-line no-unused-vars
let rules = {
  required: (value) => !!value || 'Field is required',
}

const form = ref({})
if (props.item) {
  form.value = props.item
}

const submit = () => {
  let thisForm = useForm(form.value)
  console.log(form.value)
  if (props.item)
    thisForm.patch(`/${props.subject}/${props.item.id}`, {
      onSuccess: () => {
        router.visit(`/${props.subject}`)
      },
    })
  else
    thisForm.post(`/${props.subject}`, {
      onSuccess: () => {
        router.visit(`/${props.subject}`)
      },
    })
}
</script>

<template>
  <v-card>
    <v-form @submit.prevent="submit">
      <v-card-text>
        <v-row>
          <v-col v-for="field in fields" :key="field.name" v-bind="field.wrapper_binds">
            <v-textarea
              v-if="field.field_binds.type == 'textarea'"
              v-model="form[field.name]"
              v-bind="field.field_binds"
              :rules="field.rules && field.rules.includes('required') ? [rules.required] : []"
            />
            <v-checkbox
              v-else-if="field.field_binds.type == 'checkbox'"
              v-bind="field.field_binds"
              :rules="field.rules && field.rules.includes('required') ? [rules.required] : []"
            />
            <v-autocomplete
              v-else-if="field.field_binds.type == 'select'"
              v-model="form[field.name]"
              v-bind="field.field_binds"
              :rules="field.rules && field.rules.includes('required') ? [rules.required] : []"
            />
            <v-text-field
              v-else
              v-model="form[field.name]"
              v-bind="field.field_binds"
              :rules="field.rules && field.rules.includes('required') ? [rules.required] : []"
            />
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <Link :href="route(`${subject}.index`)" as="div">
          <v-btn text>Cancel</v-btn>
        </Link>
        <v-btn type="submit" color="primary">
          <span v-if="item">Edit</span>
          <span v-else>Create</span>
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>
