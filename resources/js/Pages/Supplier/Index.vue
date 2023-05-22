<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import 'vue3-toastify/dist/index.css';
import Loading from "vue-loading-overlay";
import axios from "axios";
import Alert from "../../Components/Alert.vue";
export default defineComponent({
    props: ["suppliers"],
    data() {
        return {
            q: "",
            s: "",
            message: '',
            tbody: [
                "Company Name",
                "Supplier Name",
                "Website",
                "Description",
                "Action",
            ],
            checkbox: [],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        Loading,
        Alert
    },
    methods: {
        confirmDelete(id, index) {
            const supplier_name = this.suppliers.data[index].supplier_name;
            Swal.fire({
                title: "Are you sure you want to delete " + supplier_name + " ?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete("/supplier/" + id)
                        .then((response) => {
                            toast.success(response.data.message);
                            if (response.data.success) {
                                this.suppliers.data.splice(index, 1);
                                return;
                            }
                        })
                        .catch((error) => {
                            if (error.response.status == 400) {
                                toastr.error(error.response.data.message);
                            }
                        });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: supplier_name + " was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }

            });
        },
        search() {
            Inertia.get(
                "/supplier",
                { q: this.q, status: this.s },
            );
        },
        filterFunction(value, index, arr) {
            if (value === this.suppliers.data[index].id) {
                // Removes the value from the original array
                arr.splice(index, 1);
                return true;
            }
            return false;
        },
        selectSupplier(index) {
            const x = this.checkbox.filter(this.filterFunction);
            this.checkbox.push(this.suppliers.data[index].id);
        },
        selectAllSuppliers() {
            const checkboxes = document.querySelectorAll('input[type=checkbox]');
            const list = [];
            checkboxes.forEach((cb) => { cb.checked = true; });
            this.suppliers.data.map(function (value, key) {
                list.push(value.id)
            });
            this.checkbox = list;
        },

        deleteSupplier(index) {

            axios
                .post("/suppliers/delete", { ids: this.checkbox })
                .then((response) => {
                    if (response.data.success == true) {
                        toast.success(response.data.message);
                        this.suppliers.data.splice(index, this.checkbox.length);

                        return;
                    }
                    else {
                        toast.error(response.data.message);
                    }
                }).finally({
                    checkbox: false,
                })
        }
    }

});
</script>
<template>
    <AppLayout title="Supplier">


        <Head title="Supplier" />
        <div class="card card-flush">
            <div>
                <form class="card-header align-items-center py-5 gap-2 gap-md-5" @submit.prevent="search()">
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
                        <input type="text" v-model="q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                    <!--end::Search-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add industries-->
                        <Link href="/supplier/create" class="btn btn-primary">
                        Add Supplier
                        </Link>
                        <!--end::Add industries-->
                        <button v-if="checkbox.length > 0" @click="deleteSupplier()" class="btn btn-danger">Delete
                            Selected</button>
                    </div>
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
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th class="w-5px pe-0" rowspan="1" colspan="1" aria-label="">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" @change="selectAllSuppliers()">
                                    </div>
                                </th>
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(supplier, index) in suppliers?.data" :key="index">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" @input="selectSupplier(index)">
                                    </div>
                                </td>

                                <td>

                                    <Link :href="'/supplier/' + supplier.id"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1">{{
                                            supplier.company?.company_name }}</Link>
                                </td>
                                <td>{{ supplier?.supplier_name }}</td>
                                <td>{{ supplier?.website }}</td>
                                <td>{{ supplier?.description }}</td>

                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            :id="`dropdown-${supplier.id}`" data-bs-toggle="dropdown"
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
                                            :aria-labelled:by="`dropdown-${supplier.id}`">
                                            <li class="menu-item px-3">
                                                <Link
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                    :href="`/supplier/${supplier.id}/edit`">Edit
                                                </Link>
                                            </li>
                                            <li class="menu-item px-3">
                                                <Link
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                    :href="`/supplier/${supplier.id}`">View
                                                </Link>
                                            </li>

                                            <li class="menu-item px-3">
                                                <button @click="confirmDelete(
                                                    supplier.id, index
                                                )
                                                    " class="btn btn-sm dropdown-item">
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="suppliers?.meta">
                    <Pagination :links="suppliers?.meta.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
