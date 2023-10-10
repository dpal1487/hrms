<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import utils from "../../utils.js";
import Multiselect from "@vueform/multiselect";

export default defineComponent({
    props: ["generals"],
    data() {
        return {
            form: {},
            title: "General Settings",
            isLoading: false,
            tbody: [
                "Name",
                "Value",
                "Auto Load",
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
        Multiselect,
    },
    methods: {
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('general.destroy', id), this.generals.data, index);
            this.isLoading = false;
        },

        search() {
            Inertia.get(
                "/generals",
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
                <span class="text-muted">{{ title }}</span>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/general/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New General</Link>
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
                    <table class="table align-center table-row-dashed fs-6  text-left">
                        <thead>
                            <tr class="text-gray-800 fw-bold fs-6 text-uppercase ">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-capitalize text-left">
                            <tr v-for="(general, index) in generals?.data" :key="index">
                                <td>
                                    <span class="text-gray-800 fs-5 fw-bold">{{
                                        general?.general
                                    }}</span>
                                </td>
                                <td>
                                    <span class="text-gray-800 fs-5 fw-bold">{{
                                        general?.value
                                    }}</span>
                                </td>
                                <td>
                                    <span v-html="general?.message"></span>
                                </td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/general/${general.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        general.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="generals?.meta">
                    <Pagination :links="generals?.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
