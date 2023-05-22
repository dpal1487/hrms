<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";

import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import useVuelidate from "@vuelidate/core";
import SearchComponent from "../../Components/SearchComponent.vue"
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ['invoices'],
    setup() {
        return { v$: useVuelidate() };
    },
    data() {
        return {
            q: "",
            s: "",
            message: '',
            tbody: [
                "Invoice Number",
                "Client Name",
                "Company Name",
                "Invoice Date",
                "Invoice Due date",
                "View",
            ],
            isLoading: false,
            statusOptions: [
                { value: "all", label: "All" },
                { value: 1, label: "Active" },
                { value: 0, label: "Inactive" }
            ],
            filteredStatus: [],
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        Pagination,
        Multiselect,
        SearchComponent
    },
    methods: {
        onAvatarChange(e) {
            this.avatar = URL.createObjectURL(e.target.files[0]);
        },

        search() {
            Inertia.get(
                "/invoices",
                { q: this.q, status: this.s },
            );
        },
        created() {

        },
    }
});
</script>
<template>
    <Head title="Invoice" />

    <AppLayout title="Company">
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header />


                <!--begin::Billing History-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <h3>Invoices</h3>
                        </div>
                        <!--begin::Card toolbar-->
                    </div>

                    <!--end::Card header-->
                    <!--begin::Tab Content-->
                    <div class="tab-content">
                        <!--begin::Tab panel-->
                        <div class="card-body p-0 tab-pane fade show active">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                    <thead
                                        class="text-uppercase border-bottom border-gray-200 fs-6 text-gray-600 fw-bold bg-light bg-opacity-75">
                                        <tr>
                                            <th v-for="(th, index) in tbody" :key="index">
                                                {{ th }}
                                            </th>
                                        </tr>

                                    </thead>
                                    <tbody class="fw-bold text-gray-800 fs-5">
                                        <tr v-for="(invoice, index) in invoices.data" :key="index">

                                            <td>{{ invoice?.invoice_number }}</td>
                                            <td>{{ invoice?.client.name }}</td>
                                            <td>{{ invoice?.company?.company_name }}</td>
                                            <td>{{ invoice?.invoice_date }}</td>
                                            <td>
                                                {{ invoice?.invoice_due_date }}
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                        :id="`dropdown-${invoice?.id}`" data-bs-toggle="dropdown"
                                                        aria-expanded="false">Actions
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>

                                                    <ul class="dropdown-menu text-small menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        :aria-labelled:by="`dropdown-${invoice?.id}`">
                                                        <!-- <li class="menu-item px-3">
                                                            <Link
                                                                class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                                :href="`/company/${invoice?.id}/edit`">Edit
                                                            </Link>
                                                        </li> -->
                                                        <li class="menu-item px-3">
                                                            <Link
                                                                class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                                :href="`/company/${invoice?.id}`">View
                                                            </Link>
                                                        </li>

                                                        <!-- <li class="menu-item px-3">
                                                            <button @click="confirmDelete(
                                                                invoice?.id, index
                                                            )
                                                                " class="btn btn-sm dropdown-item">
                                                                Delete
                                                            </button>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_billing_year" class="card-body p-0 tab-pane fade" role="tabpanel"
                            aria-labelledby="kt_billing_year">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                    <thead
                                        class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bold bg-light bg-opacity-75">
                                        <tr>
                                            <td class="min-w-150px">Date</td>
                                            <td class="min-w-250px">Description</td>
                                            <td class="min-w-150px">Amount</td>
                                            <td class="min-w-150px">Invoice</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Dec 01, 2021</td>
                                            <td>
                                                <a href="#">Billing for Ocrober 2022</a>
                                            </td>
                                            <td>$250.79</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Oct 08, 2021</td>
                                            <td>
                                                <a href="#">Statements for September 2022</a>
                                            </td>
                                            <td>$98.03</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Aug 24, 2021</td>
                                            <td>Paypal</td>
                                            <td>$35.07</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Aug 01, 2021</td>
                                            <td>
                                                <a href="#">Invoice for July 2022</a>
                                            </td>
                                            <td>$142.80</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Jul 01, 2021</td>
                                            <td>
                                                <a href="#">Statements for June 2022</a>
                                            </td>
                                            <td>$123.79</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Jun 17, 2021</td>
                                            <td>Paypal</td>
                                            <td>$23.09</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_billing_all" class="card-body p-0 tab-pane fade" role="tabpanel"
                            aria-labelledby="kt_billing_all">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                    <thead
                                        class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bold bg-light bg-opacity-75">
                                        <tr>
                                            <td class="min-w-150px">Date</td>
                                            <td class="min-w-250px">Description</td>
                                            <td class="min-w-150px">Amount</td>
                                            <td class="min-w-150px">Invoice</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Nov 01, 2021</td>
                                            <td>
                                                <a href="#">Billing for Ocrober 2022</a>
                                            </td>
                                            <td>$123.79</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Aug 10, 2021</td>
                                            <td>Paypal</td>
                                            <td>$35.07</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Aug 01, 2021</td>
                                            <td>
                                                <a href="#">Invoice for July 2022</a>
                                            </td>
                                            <td>$142.80</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Jul 20, 2021</td>
                                            <td>
                                                <a href="#">Statements for June 2022</a>
                                            </td>
                                            <td>$123.79</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Jun 17, 2021</td>
                                            <td>Paypal</td>
                                            <td>$23.09</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>Jun 01, 2021</td>
                                            <td>
                                                <a href="#">Invoice for May 2022</a>
                                            </td>
                                            <td>$123.79</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab Content-->
                </div>

                <!--end::Billing Address-->
            </div>
        </div>
    </AppLayout>
</template>
