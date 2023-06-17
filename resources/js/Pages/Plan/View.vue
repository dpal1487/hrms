<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import axios from "axios";
export default defineComponent({
    props: ["plans", "message"],

    data() {
        return {

            selectedPlan: '',

            form: ({
                name: '',
                stripe_price: '',
            }),
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

});
</script>
<template>
    <app-layout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/plan" class="text-muted text-hover-primary">Plan</Link>
            </li>
        </template>

        <Head title="Plan" />
        <!--begin::Content-->

        <div class="card-toolbar text-right">
            <!--begin::Toolbar-->
            <!--begin::Add customer-->
            <Link href="/plan/create" class="btn btn-primary pull-right">
            Add New Plan
            </Link>
            <!--end::Add customer-->
            <!--end::Toolbar-->
        </div>
        <div class="card card-flush">
            <!--begin::Card toolbar-->

            <!--end::Card toolbar-->
            <!--begin::Card body-->
            <div class="card-body p-lg-17">
                <!--begin::Plans-->
                <div class="d-flex flex-column">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <h1 class="fs-2hx fw-bold mb-5">Choose Your Plan</h1>
                        <div class="text-gray-400 fw-semibold fs-5">If you need more info about our pricing, please
                            check
                            <a href="#" class="link-primary fw-bold">Pricing Guidelines</a>.
                        </div>
                    </div>
                    <div class="row g-10">
                        <div class="col-xl-4" v-for="(plan) in plans.data">
                            <div class="d-flex h-100 align-items-center">
                                <div :class="{ 'bg-success text-light': selectedPlan == `${plan.name}` }"
                                    @click="selectedPlan = `${plan.name}`"
                                    class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <div class="mb-7 text-center">
                                        <h1 class="text-dark mb-5 fw-bolder text-capitalize">{{ plan.name }}</h1>
                                        <div class="fw-semibold fs-5 mb-5">{{ plan.sort_description }}

                                        </div>
                                        <div class="text-center">
                                            <span class="mb-2 text-primary">$</span>
                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39"
                                                data-kt-plan-price-annual="399">{{ plan.price }}</span>
                                            <span class="fs-7 fw-semibold opacity-50">/
                                                <span data-kt-element="period">Mon</span></span>
                                        </div>
                                    </div>
                                    <div class="w-100 mb-10">
                                        <div class="d-flex align-items-center mb-5"
                                            v-for="(description) in JSON.parse(plan.description)">
                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{
                                                description.description }}</span>
                                            <span class="svg-icon svg-icon-1 svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <Link class="btn btn-primary mt-3" :href="`/plan/${plan.slug}/payment`">
                                    Choose
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
