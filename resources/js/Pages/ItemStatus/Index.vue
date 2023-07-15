<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import utils from "../utils.js";

export default defineComponent({
    props: ["itemstatuss"],
    data() {
        return {
            form: {},
            title: "Item Status",
            isLoading: false,
            tbody: [
                "Label",
                "Text",
                "DESCRIPTION",
                "Action",
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Loading,
    },
    methods: {
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('item-status.destroy', id), this.itemstatuss.data, index);
            this.isLoading = false;
        },

        search() {
            Inertia.get(
                "/item-status",
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
                <Link href="/item-status" class="text-muted text-hover-primary">Item Status</Link>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <Link href="/item-status/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add Item Status</Link>
                <!--end::Primary button-->
            </div>
        </template>

        <Head :title="title" />
        <div class="card card-flush">

            <!--begin::Actions-->
            <div>
                <!--begin::Card title-->
                <form class="card-header justify-content-start py-5 gap-2" @submit.prevent="search()">
                    <!--begin::Search-->
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
                    <table class="table align-center table-row-dashed fs-6 gy-5 text-center">
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
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(itemstatus, index) in itemstatuss.data" :key="index">

                                <td>
                                    <div class="d-flex">
                                        <!--begin::Thumbnail-->
                                        <!--end::Thumbnail-->
                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <span class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1">{{
                                                itemstatus?.label
                                            }}</span>
                                            <!--end::Title-->
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ itemstatus?.text }}
                                </td>
                                <td>
                                    <span v-html="itemstatus?.description"></span>
                                </td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/item-status/${itemstatus.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        itemstatus.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>

                                <!--end::Action=-->
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                    v-if="itemstatuss.meta">
                    <Pagination :links="itemstatuss.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
