<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";

import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import useVuelidate from "@vuelidate/core";
import SearchComponent from "../../Components/SearchComponent.vue";
import FormEmail from "./Components/Email/FormEmail.vue";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import axios from "axios";

export default defineComponent({
    props: ['emails'],
    setup() {
        return { v$: useVuelidate() };
    },
    data() {
        return {
            isEdit: false,
            isLoading: false,
            email: [],
            showModal: false,
            q: "",
            s: "",
            message: '',
            tbody: [
                "Email ID",
                "Is Primary",
                "Action",
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
        SearchComponent,
        FormEmail
    },
    methods: {
        toggleModal(value, email) {

            if (value, email) {
                this.isEdit = true;
                this.showModal = true;
                this.email = email;
            }
            else {
                this.showModal = false;
            }

            if (value) {
                this.showModal = true;
            }
            else {
                this.showModal = false;
            }
        },
        confirmDelete(id, index) {

            this.isLoading = true;

            Swal.fire({
                title: "Are you sure you want to delete ?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {

                    axios
                        .delete(this.route("email.delete", ['company', id]))
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message);
                                this.emails.data.splice(index, 1);
                                return;
                            }
                            else {
                                toast.error(error.response.data.message);
                            }
                        })
                        .catch((error) => {
                            if (error.response.status == 400) {
                                toast.error(error.response.data.message);
                            }
                        });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: " was not deleted.",
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
    },

});
</script>
<template>
    <Head title="Emails" />

    <AppLayout title="Company">
        <FormEmail v-if="showModal" :show="showModal" :isEdit="isEdit" @hidemodal="toggleModal" :email="email" />
        <div class="app-content flex-column-fluid ">
            <div class="app-container container-xxl">
                <Header />

                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Emails</h3>
                        </div>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <!--begin::Add industries-->
                            <button type="button" class="btn btn-primary px-6 align-self-center text-nowrap"
                                @click=toggleModal(true)>New
                                Email</button>
                        </div>
                    </div>

                    <!--end::Card header-->
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
                            <tbody class="fw-semibold text-gray-600">
                                <tr v-for="(email, index) in  emails?.data " :key="index">
                                    <td>{{ email?.email_address }}</td>
                                    <td v-if="(email?.is_primary == 1)">Primary</td>
                                    <td v-if="(email?.is_primary == 0)"></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                :id="`dropdown-${email?.id}`" data-bs-toggle="dropdown"
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
                                                :aria-labelled:by="`dropdown-${email?.id}`">
                                                <li class="menu-item px-3">
                                                    <button
                                                        class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                        @click="toggleModal(true, email)">Edit</button>
                                                    <!-- <Link
                                                            class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                            :href="`/company/${email?.id}/edit`">Edit
                                                        </Link> -->
                                                </li>
                                                <li class="menu-item px-3">
                                                    <button @click="confirmDelete(email.id, index)"
                                                        class="btn btn-sm dropdown-item align-items-center justify-content-center">
                                                        Delete
                                                    </button>
                                                </li>
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
            </div>
        </div>


    </AppLayout>
</template>
