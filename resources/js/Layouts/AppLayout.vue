<script setup>
import Header from '@/Components/Header.vue'
import FooterComponent from '@/Components/Footer.vue'

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
      <FooterComponent />
  </div>
</template>
