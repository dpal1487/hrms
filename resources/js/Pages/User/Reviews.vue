<script>
import { defineComponent } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Review from "../CustomerReviews/Components/Review.vue";
import Pagination from "../../Jetstream/Pagination.vue";

export default defineComponent({
    props: ['address', 'user', 'reviews'],
    data() {
        return {
            title: "Reviews",
            form: {}
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        Review,
        Pagination
    },
    methods: {

    },
    created() {

    }
});
</script>
<template>
    <Head :title="title" />
    <AppLayout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/users" class="text-muted text-hover-primary">Users</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="text-muted text-hover-primary">
                {{ user?.data?.first_name }}
            </li>
        </template>
        <Header :user="user?.data" :address="address?.data" />
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Reviews</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <Review :reviews="reviews?.data" />
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="reviews?.meta">
                    <Pagination :links="reviews?.meta.links" />
                </div>

            </div>
        </div>
    </AppLayout>
</template>
