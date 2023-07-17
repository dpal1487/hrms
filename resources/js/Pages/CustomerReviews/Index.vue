<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import utils from "../utils";
import Rating from "./Rating.vue";


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
        Rating
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
        <div class="card card-flush">
            <!--begin::Actions-->
            <div>
                <!--begin::Card title-->
                <form class="card-header justify-content-start py-5 gap-2" @submit.prevent="search()">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                    <!--begin::Card title-->
                </form>

            </div>
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-center">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">

                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(customer_review, index) in customer_reviews?.data" :key="index">

                                <td>
                                    {{ customer_review?.user?.first_name + " " + customer_review?.user?.last_name }}
                                </td>
                                <td>
                                    {{ customer_review?.review?.title }}
                                </td>
                                <td>
                                    {{ customer_review?.review?.content }}
                                </td>
                                <td class="text-end" data-order="rating-5">
                                    <Rating :rating="customer_review?.review?.rating" />
                                </td>
                                <td>
                                    {{ customer_review?.ip_address }}
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                    v-if="customer_reviews.meta">
                    <Pagination :links="customer_reviews.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
