<script setup>
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineOptions({ layout: GuestLayout })

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  auth: Object,
})
</script>

<template>
  <Head title="Welcome" />
  <div style="display: flex; justify-content: center; text-align: center; flex-direction: column">
    <span class="text-h5 mb-4">StarterKit</span>
    <p class="text-body-2 mb-4">Questa è la pagina Welcome.vue, per cominciare registra un utente e loggati.</p>

    <div v-if="props.auth.user != null">
      <Link :href="route('dashboard')" as="div">
        <v-btn color="primary">Dashboard</v-btn>
      </Link>
    </div>
    <div v-else>
      <div class="d-flex" style="justify-content: center">
        <Link v-if="props.canLogin" :href="route('login')" class="mr-2" as="div">
          <v-btn color="primary">Login</v-btn>
        </Link>
        <Link v-if="props.canRegister" :href="route('register')" as="div">
          <v-btn color="secondary">Sign Up</v-btn>
        </Link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'WelcomePage',
}
</script>
