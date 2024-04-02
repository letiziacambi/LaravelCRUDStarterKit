<script setup>
import { router, usePage } from '@inertiajs/vue3'
import navigation from '@/Configs/navigation'

function activeItemCheck(to) {
  // eslint-disable-next-line no-undef
  let paramUrl = route(to).replace(window.location.origin, '')
  let currentUrl = usePage().url
  return paramUrl == currentUrl ? 'v-list-item--active' : ''
}
</script>

<template>
  <v-list nav density="compact">
    <!-- List Menu -->
    <div v-for="(item, key) in navigation.items" :key="key">
      <v-list-item
        v-if="item.link_type == 'external'"
        :prepend-icon="item.icon"
        :title="item.title"
        :exact="item.exact"
        link
        :href="item.to"
        target="_blank"
      />
      <v-list-item
        v-else-if="item.type == 'link'"
        :prepend-icon="item.icon"
        :title="item.title"
        :exact="item.exact"
        link
        :class="activeItemCheck(item.to)"
        @click="router.visit(route(item.to))"
      />
      <v-list-group v-else-if="item.type == 'group'" :value="item.title" sub-group>
        <template #activator="{ props }">
          <v-list-item v-bind="props" :prepend-icon="item.icon" :title="item.title"></v-list-item>
        </template>

        <template v-for="(child, childKey) in item.children" :key="childKey">
          <v-list-item
            v-if="child.link_type == 'external'"
            :prepend-icon="child.icon"
            :title="child.title"
            :exact="child.exact"
            link
            :href="child.to"
            target="_blank"
          />
          <v-list-item
            v-else
            :prepend-icon="child.icon"
            :title="child.title"
            :exact="child.exact"
            link
            :class="activeItemCheck(child.to)"
            @click="router.visit(route(child.to))"
          />
        </template>
      </v-list-group>
    </div>
  </v-list>
</template>
