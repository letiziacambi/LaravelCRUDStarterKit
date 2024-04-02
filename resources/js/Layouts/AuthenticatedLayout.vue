<script setup>
import AvatarNoImage from '../../images/avatar-no-image.png'
import NavigationMenu from '@/Components/NavigationMenu.vue'
import { router } from '@inertiajs/vue3'
</script>

<script>
import { useToast } from 'vue-toastification'

export default {
  data() {
    return {
      drawer: false,
      rail: false,
    }
  },
  computed: {
    avatar() {
      return AvatarNoImage
    },
  },
  watch: {
    $page: {
      handler() {
        const toast = useToast()
        const flash = this.$page.props.flash
        if (flash.success) {
          toast.success(flash.success)
        } else if (flash.error) {
          toast.error(flash.error)
        }
      },
    },
  },
  mounted() {
    this.drawer = !this.$vuetify.display.mobile
  },
}
</script>

<template>
  <v-app class="bg-grey-lighten-4">
    <v-navigation-drawer v-model="drawer" :rail="rail" expand-on-hover permanent color="primary">
      <v-list>
        <v-list-group>
          <template #activator="{ props }">
            <v-list-item
              v-bind="props"
              :prepend-avatar="avatar"
              :title="$page.props.auth.user.name"
              :subtitle="$page.props.auth.user.email"
            />
          </template>

          <v-list-item
            prepend-icon="mdi-exit-to-app"
            title="Log Out"
            link
            @click="router.visit(route('logout'), { method: 'post' })"
          />
        </v-list-group>
      </v-list>
      <v-divider />
      <NavigationMenu />
    </v-navigation-drawer>
    <v-app-bar elevation="0">
      <v-app-bar-nav-icon v-if="$vuetify.display.mobile" @click.stop="drawer = !drawer" />
      <v-app-bar-nav-icon v-else @click.stop="rail = !rail" />
      <v-toolbar-title text="Starter Kit" />
    </v-app-bar>
    <v-main>
      <v-container>
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>
