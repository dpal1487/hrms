
<script>
import { defineComponent } from "vue"
import { Head, Link } from '@inertiajs/inertia-vue3';
import Welcome from "@/Jetstream/Welcome.vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import Login from "../Pages/Auth/Login.vue";
import Register from "../Pages/Auth/Register.vue";

export default defineComponent({
  components: {
    Head,
    Link,
    Welcome,
    AppLayout,
    Login,
    Register
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

  <div v-if="canLogin">
    <app-layout title="Dashboard" v-if="$page.props.user" :href="route('dashboard')">
      <template #header>
        <h2 class="h4 font-weight-bold">
          Dashboard
        </h2>
      </template>
      <welcome />
    </app-layout>

    <template v-else>
      <Link :href="route('login')" class="text-muted">
      <Login />
      </Link>

      <Link v-if="canRegister" :href="route('register')" class="ms-4 text-muted">
      <Register />
      </Link>
    </template>
  </div>
</template>

<style scoped></style>
