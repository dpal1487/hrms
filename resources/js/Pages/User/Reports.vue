<script>
import { defineComponent } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";

export default defineComponent({
    props: ['address', 'user', 'reports'],

    data() {
        return {
            title: 'Reports',
            tbody: [
                "Name",
                "Report Type",
                "Notes",
                "Action",
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
                    <h3 class="fw-bold m-0">Reports</h3>
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
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(report, index) in reports?.data" :key="index">
                                <td>

                                </td>

                                <td>{{ report }}</td>
                                <td>{{ report?.mobile }}</td>
                                <td>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="reports?.meta">
                    <Pagination :links="reports?.meta.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
