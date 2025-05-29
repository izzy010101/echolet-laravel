<script setup>
import Header from '@/Components/Header.vue'

const props = defineProps({
  auth: Object
})
</script>

<template>
  <div>
    <Header :auth="auth" />
    <main>
      <slot />
    </main>
  </div>
</template>
