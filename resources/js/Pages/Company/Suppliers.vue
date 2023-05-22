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
import { toast } from "vue3-toastify";

export default defineComponent({
    props: ['suppliers'],
    setup() {
        return { v$: useVuelidate() };
    },
    data() {
        return {
            q: "",
            s: "",
            message: '',
            tbody: [
                "Company Name",
                "Supplier Name",
                "Website",
                "Skype Profile",
                "Linkdin Profile",
                "Description",
                "Status"
            ],
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
                "/suppliers",
                { q: this.q, status: this.s },
            );
        },
        changeStatus(e, id) {
            this.isLoading = true;
            axios
                .post("/company/suppliers/status", { id: id, status: e })
                .then((response) => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        return;
                    }
                    toast.error(response.data.message);
                })
                .finally(() => (this.isLoading = false));
        },
    }
});
</script>
<template>
    <Head title="Suppliers" />

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
                            <h3>Suppliers</h3>
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
                                        <tr v-for="(supplier, index) in suppliers.data" :key="index">

                                            <td>{{ supplier?.company?.company_name }}</td>
                                            <td>{{ supplier?.supplier_name }}</td>
                                            <td>{{ supplier?.website }}</td>
                                            <td>{{ supplier?.skype_profile }}</td>
                                            <td>
                                                {{ supplier?.linkedIn_profile }}
                                            </td>
                                            <td>
                                                {{ supplier?.description }}
                                            </td>

                                            <td>
                                                <div
                                                    class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                                    <input class="form-check-input h-20px w-30px" type="checkbox"
                                                        @input="changeStatus($event.target.checked, supplier.id)"
                                                        :checked="supplier.status == 1 ? true : false" />
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
