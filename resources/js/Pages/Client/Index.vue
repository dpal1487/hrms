<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";
import Multiselect from "@vueform/multiselect";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
export default defineComponent({
    props: ["clients"],
    data() {
        return {
            q: "",
            s: "",
            tbody: [
                "Company Name",
                "Display Name",
                "Status",
                "Created At",
                "Action",
            ],
            isLoading: false,
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
        updateStatus(id, e) {
            this.isLoading = true;
            axios
                .post("/supplier/status", { id: id, status: e })
                .then((response) => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        return;
                    }
                    toast.error(response.data.message);
                })
                .finally(() => (this.isLoading = false));
        },
        confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        "Deleted!",
                        "Your item has been deleted.",
                        "success"
                    );
                }
            });
        },
        search() {
            Inertia.get(
                "/client",
                { q: this.q, status: this.s },
                {
                    preserveState: true,
                }
            );
        },
    },
});
</script>
<template>
    <app-layout>
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />

        <Head title="Clients" />
        <div class="card card-flush">
            <!--begin::Actions-->
            <div>
                <form @submit.prevent="search" class="card-header align-items-center py-5 gap-2 gap-md-5">
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
                            placeholder="Search Client" />
                    </div>
                    <div class="w-100 mw-200px">
                        <!--begin::Select2-->
                        <Multiselect :options="$page.props.ziggy.status" label="label" valueProp="value"
                            class="form-control form-control-solid" placeholder="Select Status" v-model="s" />
                        <!--end::Select2-->
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                    <!--end::Search-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add project-->
                        <Link href="/client/create" class="btn btn-primary">
                        Add Client
                        </Link>
                        <!--end::Add project-->
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
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(client, index) in clients.data" :key="index">
                                <td>
                                    <Link :href="'/client/' + client.id"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                        project-filter="project_name">{{ client.name }}</Link>
                                </td>
                                <td>{{ client.display_name }}</td>
                                <td>
                                    <span :class="`badge bg-${client.status == 1
                                        ? 'success'
                                        : 'danger'
                                        }`">{{ client.status }}</span>
                                </td>
                                <td>{{ client.created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            :id="`dropdown-${client.id}`" data-bs-toggle="dropdown"
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
                                            :aria-labelled:by="`dropdown-${client.id}`">
                                            <li class="menu-item px-3">
                                                <Link class="dropdown-item" :href="`/project/${client.id}/edit`">Edit
                                                </Link>
                                            </li>
                                            <li class="menu-item px-3">
                                                <Link class="dropdown-item" :href="`/project/${client.id}/edit`">Add Link
                                                </Link>
                                            </li>
                                            <li class="menu-item px-3">
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li class="menu-item px-3">
                                                <button @click="confirmDelete(
                                                    client.id
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
                <!-- <div class="row" v-if="suppliers.meta">
                                <div
                                    class="col-sm-12 d-flex align-items-center justify-content-center justify-content-md-end"
                                >
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        <Pagination :links="suppliers.meta.links" />
                                    </div>
                                </div>
                            </div> -->
                <!--end::Table-->
            </div>
        </div>
    </app-layout>
</template>
