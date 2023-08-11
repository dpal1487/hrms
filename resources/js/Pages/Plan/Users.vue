<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ['plan', 'users'],

    components: {
        AppLayout,
        Header,
        Link,
        Head,
        Pagination
    },
    data() {
        return {
            title: "Plan Users",
            null: '',
            form: {},
            tbody: [
                "Name",
                "Email",
                "Mobile",
                "Start Date",
                "End Date",
            ],
        };
    },
    methods: {
        search() {
            Inertia.get(
                `/plan/${this.plan?.data?.id}/users`,
                this.form,
            );
        },
    },
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
                <Link href="/plans" class="text-muted text-hover-primary">Plans</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="text-muted">
                {{ plan?.data?.name }}
            </li>
        </template>
        <Header :plan="plan?.data" />
        <div class="card">
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Users List</h2>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div>
                        <form class="card-header justify-content-start py-5 gap-4" @submit.prevent="search()">
                            <div class="d-flex align-items-center position-relative">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                <input type="text" v-model="form.q" class="form-control form-control-sm w-250px ps-14"
                                    placeholder="Search " />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-3 text-left">
                                <thead>
                                    <tr class="text-gray-800 fw-bold fs-6 text-uppercase">
                                        <th v-for="(th, index) in tbody" :key="index">
                                            {{ th }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    <tr v-for="(user, index) in users?.data" :key="index">
                                        <td class="fs-6 fw-bold text-gray-700">
                                            {{ user?.first_name }} {{ user?.last_name }}
                                        </td>
                                        <td class="fs-6 fw-bold text-gray-700">
                                            {{ user?.email }}
                                        </td>
                                        <td class="fs-6 fw-bold text-gray-700">
                                            {{ user?.mobile }}
                                        </td>
                                        <td class="fs-6 fw-bold text-gray-700">
                                            {{ user?.start_at }}
                                        </td>
                                        <td class="fs-6 fw-bold text-gray-700">
                                            {{ user?.end_at }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                            v-if="plan.meta">
                            <Pagination :links="plan.meta.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
