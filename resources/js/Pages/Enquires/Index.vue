<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import utils from "../utils";
export default defineComponent({
    props: ["enquiries"],

    data() {
        return {
            form: {},
            tbody: [
                "Name",
                "Email",
                "Mobile",
                "Message",
                "IP Address",
                "Status",
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


        search() {
            Inertia.get(
                "/department",
                this.form,
            );
        },
        async changeStatus(status, id) {
            this.isLoading = true;
            await utils.changeStatus(route('enquire.status'), { id: id, status: status });
            this.isLoading = false;
        },
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
                <Link href="/department" class="text-muted text-hover-primary">Department</Link>
            </li>
        </template>

        <Head title="Department" />
        <div class="card card-flush">
            <!--begin::Actions-->
            <div>
                <!--begin::Card title-->
                <form class="card-header justify-content-start py-5 gap-2" @submit.prevent="search()">
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
                    <!--begin::Card title-->
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
                            <tr v-for="(enquiry, index) in enquiries.data" :key="index">

                                <td>
                                    {{ enquiry?.name }}
                                </td>
                                <td>
                                    {{ enquiry?.email }}
                                </td>
                                <td>
                                    {{ enquiry?.mobile }}
                                </td>
                                <td>
                                    {{ enquiry?.message }}
                                </td>
                                <td>
                                    {{ enquiry?.ip_address }}
                                </td>

                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="changeStatus($event.target.checked, enquiry.id)"
                                            :checked="enquiry.status == 1 ? true : false" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="enquiries.meta">
                    <Pagination :links="enquiries.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
