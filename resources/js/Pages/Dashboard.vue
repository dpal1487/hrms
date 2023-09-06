<template>
  <app-layout title="Dashboard" :notifications="notifications">
    <template #header>
      <h2 class="h4 font-weight-bold">
        Dashboard
      </h2>
    </template>
    <welcome />
  </app-layout>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import Welcome from "@/Jetstream/Welcome.vue"
export default defineComponent({
  props: ['notifications' , 'headers'],
  components: {
    AppLayout,
    Welcome
  }
});
</script>
