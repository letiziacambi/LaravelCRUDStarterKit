<script>
export default { name: 'CRUDIndex' }
</script>

<script setup>
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { Link, Head } from '@inertiajs/vue3'
import CrudDelete from '@/Components/CrudDelete.vue'
import _ from 'lodash'

const props = defineProps({
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

const parentProjects = _.filter(props.data.data, { parent_id: null })
</script>

<template>
  <Head :title="entity" />
  <div class="mb-5">
    <h5 class="text-h5 font-weight-bold">{{ entity }}</h5>
    <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />
  </div>
  <Link v-if="actions['create']" :href="route(`${subject}.create`)" as="div">
    <v-btn color="primary">Create</v-btn>
  </Link>
  <v-row dense>
    <v-col v-for="d in parentProjects" :key="d.id" cols="4">
      <v-card :href="route(`${subject}.show`, d.id)">
        <!-- <v-img
              :src="card.src"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="200px"
            >-->
        <v-card-title>{{ d.name }}</v-card-title>
        <!--</v-img>-->

        <v-card-actions>
          <v-spacer></v-spacer>

          <CrudDelete v-if="actions['delete']" :item="d" :subject="subject" />
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>
