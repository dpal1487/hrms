<script>
import { defineComponent } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
import PlanForm from './Components/PlanForm.vue';
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Multiselect from '@vueform/multiselect';
import utils from '../utils';
export default defineComponent({
    props: ['plans'],
    emits: ['Onhide'],
    data() {
        return {
            item: [],
            title: "Plans",
            form: {},
            tbody: [
                "NAME",
                "DESCRIPTION",
                "Category",
                "AMMOUNT",
                "Status",
                "Action",
            ],
            isLoading: false,
            fullPage: true,
        }
    },
    components: {
        Head,
        AppLayout,
        Pagination,
        PlanForm,
        Link,
        Multiselect
    },
    methods: {
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('plan.destroy', id), this.plans.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get(
                "/plans",
                this.form,
                {
                    preserveState: true,
                }
            );
        },
        async changeStatus(status, id) {
            this.isLoading = true;
            await utils.changeStatus(route('plan.status'), { id: id, status: status });
            this.isLoading = false;
        },

    }
});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Plan
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <Link href="/plan/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Plan</Link>
                <!--end::Primary button-->
            </div>
        </template>
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Actions-->
            <div>
                <form class="card-header justify-content-start py-5 gap-2 gap-md-5" @submit.prevent="search">
                    <!--begin::Card title-->
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
                    <div class="w-100 mw-200px">
                        <!-- {{ $page.props.ziggy.status }} -->
                        <Multiselect :options="$page.props.ziggy.status" label="name" valueProp="value"
                            class="form-control form-control-solid" placeholder="Select Status" v-model="form.s" />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                    <!--end::Search-->
                    <!--end::Card toolbar-->
                </form>
            </div>
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-center">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-gray-400 text-center fw-bold fs-7 min-w-100px text-uppercase">
                                <th class="min-w-100px" v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <tr class="text-center" v-for="(plan, index) in plans?.data" :key="index">
                                <td>
                                    <div class="ms-5">
                                        <span class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1">{{ plan?.name }}
                                        </span>

                                    </div>
                                </td>
                                <td>
                                    {{ plan?.sort_description }}
                                </td>
                                <td>
                                    {{ plan?.category?.name }}
                                </td>
                                <td>
                                    {{ plan?.price }}
                                </td>
                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="changeStatus($event.target.checked, plan.id)"
                                            :checked="plan.status == 1 ? true : false" />
                                    </div>
                                </td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/plan/${plan?.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        plan?.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->

                <div class="row" v-if="plans.meta">
                    <div class="col-sm-12 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <Pagination :links="plans.meta.links" />
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </app-layout>
</template>