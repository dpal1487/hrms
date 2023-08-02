
<script>
import { defineComponent } from "vue"
import { Head, Link } from '@inertiajs/inertia-vue3';
import Welcome from "@/Jetstream/Welcome.vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import Login from "../Pages/Auth/Login.vue";

export default defineComponent({
  components: {
    Head,
    Link,
    Welcome,
    AppLayout,
    Login,
  },

  props: {
    canLogin: Boolean,
  }
})
</script>

<template>
  <Head title="Welcome" />

  <div v-if="canLogin" class="h-100">
    <app-layout title="Dashboard" v-if="$page.props.user" :href="route('dashboard')">
      <template #header>
        <h2 class="h4 font-weight-bold">
          Dashboard
        </h2>
      </template>
      <welcome />
    </app-layout>
    <template v-else>
      <div class="h-100">
        <Login />
      </div>
    </template>
  </div>
</template>