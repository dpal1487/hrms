<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import Review from "./Components/Review.vue";

export default defineComponent({
    props: ["customer_reviews"],

    data() {
        return {
            form: {},
            tbody: [
                "Name",
                "Title",
                "Content",
                "Rating",
                "IP Address",
            ],
            title: 'Customer Reviews',
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        Loading,
        Review
    },
    methods: {


        search() {
            Inertia.get(
                "/customer-reviews",
                this.form,
            );
        },

    },
});
</script>
<template>
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Customer Reviews</span>
            </li>
        </template>

        <Head :title="title" />
        <Review :reviews="customer_reviews" />
    </app-layout>
</template>
