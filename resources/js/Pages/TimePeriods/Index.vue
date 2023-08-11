<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import TimePeriod from "./Components/TimePeriod.vue";
export default defineComponent({
    props: ["categories", "times"],

    data() {
        return {
            form: {},
            tbody: [
                "Time Period",
                "Category",
                "Description",
                "Action",
            ],
            isLoading: false,
            title: "Time Periods",
            isModalOpen: false,
            timePeriod: {}
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        Loading,
        TimePeriod,

    },
    methods: {
        search() {
            Inertia.get(
                "/time-periods",
                this.form,
            );
        },
        showMenuModal(timeperiod) {
            this.isEdit = false;
            this.isModalOpen = true;
            this.timeperiod = timeperiod
        },
        hideMenuModal() {
            this.isModalOpen = false;
        },
        showEditMenuModal(timeperiod) {
            this.isModalOpen = true;
            this.isEdit = true;
            this.timeperiod = timeperiod
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
                <span class="text-muted">Time Periods</span>
            </li>
        </template>

        <Head :title="title" />
        <TimePeriod v-if="isModalOpen" :show="isModalOpen" :isEdit="isEdit" @hidemodal="hideMenuModal"
            :category="timeperiod" :times="times" />
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
                        <tbody class="fw-semibold text-gray-600 text-capitalize">
                            <tr v-for="(category, index) in categories.data" :key="index">
                                <td>
                                    <div class="text-gray-800 fs-5 fw-bold p-0 text-capitalize">
                                        {{ category?.times?.map(t => t.title)?.join(", ") }}
                                    </div>

                                </td>
                                <td>
                                    {{ category?.name }}
                                </td>
                                <td>
                                    <span v-html="category?.description"></span>
                                </td>

                                <td>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        @click="showEditMenuModal(category)">
                                        <i class="bi bi-view-list"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="categories.meta">
                    <Pagination :links="categories.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
