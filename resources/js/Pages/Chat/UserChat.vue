<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head, Link } from "@inertiajs/inertia-vue3";
import ChatLayout from "./Layouts/ChatLayout.vue";
import ChatScreen from "./Components/ChatScreen.vue";

export default defineComponent({

    props: ['users'],

    data() {
        return {
        }
    },
    components: {
        AppLayout,
        Head,
        Link,
        ChatLayout,
        ChatScreen
    },
    methods: {

    }
});
</script>

<template>
    <app-layout title="Chat">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Chat</span>
            </li>
        </template>
        <!--begin::Layout-->
        <ChatScreen :users="users" />
        <!--end::Layout-->
    </app-layout>
</template>