
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
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  }
})
</script>

<template>
  <Head title="Welcome" />

  <div v-if="canLogin" style="height: 100vh;">
    <app-layout title="Dashboard" v-if="$page.props.user" :href="route('dashboard')">
      <template #header>
        <h2 class="h4 font-weight-bold">
          Dashboard
        </h2>
      </template>
      <welcome />
    </app-layout>

    <template v-else>
      <Login />
    </template>
  </div>
</template>

<style scoped></style>
