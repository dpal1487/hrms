<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import utils from "../utils.js";

export default defineComponent({
    props: ["attributes"],
    data() {
        return {
            form: {},
            title: "Attributes",
            isLoading: false,
            tbody: [
                "Name",
                "Data Type",
                "CATEGORY",
                "FIELD",
                "Status",
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
            await utils.deleteIndexDialog(route('attribute.destroy', id), this.attributes.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get(
                "/attributes",
                this.form,
            );
        },
        async changeStatus(status, id) {
            this.isLoading = true;
            await utils.changeStatus(route('attribute.status'), { id: id, status: status });
            this.isLoading = false;
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
                <span class="text-muted">Attributes</span>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/attribute/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Attribute</Link>
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
                    <table class="table align-center table-row-dashed fs-6 gy-5 text-left">
                        <thead>
                            <tr class="text-gray-800 fw-bold fs-6 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-capitalize">
                            <tr v-for="(attribute, index) in attributes.data" :key="index">
                                <td>
                                    <Link class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                        :href="`/attribute/${attribute.id}`">{{ attribute?.name }}
                                    </Link>
                                </td>
                                <td>
                                    {{ attribute?.data_type }}
                                </td>
                                <td>
                                    {{ attribute?.category?.name }}
                                </td>
                                <td>
                                    {{ attribute?.field }}
                                </td>
                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="changeStatus($event.target.checked, attribute.id)"
                                            :checked="attribute.status == 1 ? true : false" />
                                    </div>
                                </td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/attribute/${attribute.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/attribute/${attribute.id}`"><i class="bi bi-view-list me-2"></i>
                                    </Link>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        attribute.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end mt-5" v-if="attributes.meta">
                    <Pagination :links="attributes.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
