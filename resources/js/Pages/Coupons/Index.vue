<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import utils from "../utils.js";

export default defineComponent({
    props: ["coupons"],

    data() {
        return {
            form: {},
            title: "Coupon",
            isLoading: false,
            tbody: [
                "Code",
                "Type",
                "DESCRIPTION",
                "Discount",
                "Expire At",
                "Action",
            ],
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
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('coupon.destroy', id), this.coupons.data, index);
            this.isLoading = false;
        },

        search() {
            Inertia.get(
                "/coupons",
                this.form,
            );
        },

    },
});
</script>
<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/coupons" class="text-muted text-hover-primary">coupon</Link>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/coupon/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New coupon</Link>
            </div>
        </template>

        <Head :title="title" />
        <div class="card card-flush">
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
                        <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-center table-row-dashed fs-6 gy-5 text-center">
                        <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(coupon, index) in coupons.data" :key="index">

                                <td>
                                    <div class="d-flex">
                                        <div class="ms-5">
                                            <span class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1">{{ coupon?.code
                                            }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ coupon?.type }}
                                </td>
                                <td>
                                    <span v-html="coupon?.descriptions"></span>
                                </td>
                                <td>
                                    {{ coupon?.discount }}
                                </td>
                                <td>
                                    {{ coupon?.expires_at }}
                                </td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/coupon/${coupon.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        coupon.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="coupons.meta">
                    <Pagination :links="coupons.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
