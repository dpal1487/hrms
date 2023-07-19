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
    props: ["banners"],

    data() {
        return {
            form: {},
            title: "Banner",
            isLoading: false,
            tbody: [
                "Title",
                "DESCRIPTION",
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
            await utils.deleteIndexDialog(route('banner.destroy', id), this.banners.data, index);
            this.isLoading = false;
        },

        search() {
            Inertia.get(
                "/banners",
                this.form,
            );
        },

        async changeStatus(status, id) {
            console.log(id)
            this.isLoading = true;
            await utils.changeStatus(route('banner.status'), { id: id, status: status });
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
                <span class="text-muted text-hover-primary">Banners</span>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <Link href="/banner/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Banner</Link>
                <!--end::Primary button-->
            </div>
        </template>

        <Head :title="title" />
        <div class="card card-flush">
            <!--begin::Actions-->
            <div>
                <!--begin::Card title-->
                <form class="card-header justify-content-start py-5 gap-2" @submit.prevent="search()">

                    <!--begin::Search-->
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
                    <table class="table align-center table-row-dashed fs-6 gy-5">
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
                            <tr v-for="(banner, index) in banners.data" :key="index">
                                <td>
                                    <div class="d-flex">
                                        <!--begin::Thumbnail-->
                                        <span
                                            class="d-block symbol symbol-50px symbol-lg-50px symbol-fixed position-relative">
                                            <img v-if="banner?.image" :src="banner?.image?.small_path" alt="image"
                                                class="rounded" />
                                            <img v-else src="/assets/media/svg/avatars/blank.svg" alt="image"
                                                class="rounded">
                                        </span>
                                        <!--end::Thumbnail-->
                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <span class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                banner-filter="banner_name">{{ banner?.title }}</span>
                                            <!--end::Title-->
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span v-html="banner?.description"></span>
                                </td>
                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="changeStatus($event.target.checked, banner.id)"
                                            :checked="banner.status == 1 ? true : false" />
                                    </div>
                                </td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/banner/${banner.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>

                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        banner.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                                <!--end::Action=-->
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="banners.meta">
                    <Pagination :links="banners.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
