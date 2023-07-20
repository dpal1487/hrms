<script>
import { defineComponent } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Index from "../CustomerReviews/Index.vue";
export default defineComponent({
    props: ['address', 'user', 'review'],

    data() {
        return {
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        Index
    },
    methods: {

    },
    created() {

    }
});
</script>
<template>
    <Head title="User Setting" />

    <AppLayout>
        <Header :user="user?.data" :address="address?.data" />
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">User Reviews</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!-- {{ review }} -->
                <Index :customer_reviews="review" />
            </div>
            <!--end::Card body-->
        </div>
    </AppLayout>
</template>
