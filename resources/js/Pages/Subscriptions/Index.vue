<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
export default defineComponent({
    props: ["subscriptions"],

    data() {
        return {
            form: {},
            tbody: [
                "Name",
                "Plan",
                "Subscription ID",
                "Order ID",
                "Payment ID",
                "Quantity",
                "Start Date",
                "End Date",
                "Status",
            ],
            isLoading: false,
            title: "Subscriptions",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        Loading,
    },
    methods: {
        search() {
            Inertia.get(
                "/subscriptions",
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
                <span class="text-muted">Subscriptions</span>
            </li>
        </template>

        <Head :title="title" />
        <div class="card card-flush">
            <div class="card-title">
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
                        <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                    </div>
                    <div class="w-100 mw-200px">
                        <Multiselect :options="$page.props.ziggy.status" label="name" valueProp="value"
                            class="form-control form-control-solid" placeholder="Select Status" v-model="form.s" />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-left">
                        <thead>
                            <tr class="text-gray-800 fw-bold fs-6 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-700">
                            <tr v-for="(subscription, index) in subscriptions.data" :key="index">
                                <td>
                                    {{ subscription?.user?.first_name + " " + subscription?.user?.last_name }}
                                </td>
                                <td>
                                    {{ subscription?.plan?.plan_id }}
                                </td>
                                <td>
                                    {{ subscription?.subscription_id }}
                                </td>   
                                <td>
                                    {{ subscription?.order_id }}
                                </td>
                                <td>
                                    {{ subscription?.payment_id }}
                                </td>
                                <td>
                                    {{ subscription?.quantity }}
                                </td>
                                <td>
                                    {{ subscription?.start_at }}
                                </td>
                                <td>
                                    {{ subscription?.end_at }}
                                </td>

                                <td>
                                    <div
                                        :class="`badge  ${subscription.status == 1 ? 'badge-light-success' : 'badge-light-danger'}`">
                                        {{ subscription.status == 1 ? 'Active' : 'Inactive' }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                    v-if="subscriptions.meta">
                    <Pagination :links="subscriptions.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
