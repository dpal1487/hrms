<script>
import { defineComponent } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";

export default defineComponent({
    props: ['address', 'user', 'packages'],

    data() {
        return {
            title: 'Packages',
            tbody: [
                "Plan Name",
                "Subscription ID",
                "Description",
                "Period",
                "AMMOUNT",
                "Currency",
            ],
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
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
            <li class="text-muted">
                {{ user?.data?.first_name }}
            </li>
        </template>
        <Header :user="user?.data" :address="address?.data" />
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ title }}</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-4 text-left">
                        <thead>
                            <tr class="text-gray-800 fw-bold fs-6 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-capitalize">
                            <tr v-for="(user_package, index) in packages?.data" :key="index">
                                <td>{{ user_package?.name }}</td>
                                <td>{{ user_package?.subscription_id }}</td>
                                <td>{{ user_package?.sort_description }}</td>
                                <td>{{ user_package?.period }}</td>
                                <td>{{ user_package?.price }}</td>
                                <td>{{ user_package?.currency }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="packages?.meta">
                    <Pagination :links="packages?.meta.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
