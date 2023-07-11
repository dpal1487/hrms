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
import 'vue-loading-overlay/dist/css/index.css';
import axios from "axios";
import utils from "../utils.js";

export default defineComponent({
    props: ["categories"],

    data() {
        return {
            form: {},
            title: "Category",
            isLoading: false,
            tbody: [
                "Category Name",
                "Meta Tag",
                "DESCRIPTION",
                "KEYWORD",
                "PARENT",
                "Status",
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
    },
    methods: {
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('category.destroy', id), this.categories.data, index);
            this.isLoading = false;
        },

        search() {
            Inertia.get(
                "/category",
                this.form,
            );
        },

        filterFunction(value, index, arr) {
            if (value === this.categories.data[index].id) {
                // Removes the value from the original array
                arr.splice(index, 1);
                return true;
            }
            return false;
        },
        selectcategory(index) {
            const x = this.checkbox.filter(this.filterFunction);
            this.checkbox.push(this.categories.data[index].id);
        },
        selectAllcategories() {
            const checkboxes = document.querySelectorAll('input[type=checkbox]');
            const list = [];
            checkboxes.forEach((cb) => { cb.checked = true; });
            this.categories.data.map(function (value, key) {
                list.push(value.id)
            });
            this.checkbox = list;
        },

        deletecategory(index) {

            axios
                .post("/categories/delete", { ids: this.checkbox })
                .then((response) => {
                    if (response.data.success == true) {
                        toast.success(response.data.message);
                        this.categories.data.splice(index, this.checkbox.length);
                        return;
                    }
                    else {
                        toast.error(response.data.message);
                    }
                }).finally({
                    checkbox: false,
                })
        },
        async changeStatus(status, id) {
            console.log(status);
            this.isLoading = true;
            await utils.changeStatus(route('category.status'), { id: id, status: status });
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
                <Link href="/category" class="text-muted text-hover-primary">category</Link>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <Link href="/category/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Category</Link>
                <!--end::Primary button-->
            </div>
        </template>

        <Head :title="title" />
        <div class="card card-flush">
            <!--begin::Actions-->
            <div>
                <!--begin::Card title-->
                <form class="card-header align-items-center py-5 gap-2 gap-md-5" @submit.prevent="search()">
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
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Toolbar-->
                        <!--end::Add Conversion Rate-->
                        <button v-if="checkbox.length > 0" @click="deletecategory()" class="btn btn-danger">Delete
                            Selected</button>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
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
                                <th class="w-5px pe-0" rowspan="1" colspan="1" aria-label="">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" @change="selectAllcategories()">
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
                            <tr v-for="(category, index) in categories.data" :key="index">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <!--begin::Thumbnail-->
                                        <Link href="#"
                                            class="d-block symbol symbol-50px symbol-lg-50px symbol-fixed position-relative">
                                        <img v-if="category?.image" :src="category?.image?.small_path" alt="image"
                                            class="rounded" />
                                        <img v-else src="/assets/media/svg/avatars/blank.svg" alt="image" class="rounded">
                                        </Link>
                                        <!--end::Thumbnail-->
                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                category-filter="category_name">{{ category?.name }}</a>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7 fw-bold">
                                                <span v-html="category?.description"></span>
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                    </div>
                                </td>
                                <!--end::Category=-->

                                <!--begin::Meta Tag-->
                                <td>
                                    <div class="d-flex">
                                        <div class="ms-5">
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7 fw-bold">
                                                {{ category?.meta ? category?.meta?.tag : '' }} </div>
                                            <!--end::Description-->
                                        </div>
                                    </div>
                                </td>
                                <!--end::Meta Tag-->

                                <!--begin::Meta Description-->
                                <td>
                                    <div class="d-flex">
                                        <div class="ms-5">
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7 fw-bold" v-if="category?.meta">
                                                <span v-html="category?.meta?.description">

                                                </span>
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                    </div>
                                </td>
                                <!--end::Meta Description-->

                                <!--begin::Meta Keywords-->
                                <td>
                                    <div class="d-flex">
                                        <div class="ms-5">
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7 fw-bold">
                                                {{ category?.meta ? category?.meta?.keywords : '' }} </div>
                                            <!--end::Description-->
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="badge badge-secondary">
                                        {{ category?.parent ? category?.parent?.name : 'Parent' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="changeStatus($event.target.checked, category.id)"
                                            :checked="category.status == 1 ? true : false" />
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            :id="`dropdown-${category.id}`" data-bs-toggle="dropdown"
                                            aria-expanded="false">Actions <i class="bi bi-chevron-down"></i>
                                        </a>
                                        <ul class="dropdown-menu text-small menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            :aria-labelled:by="`dropdown-${category.id}`">
                                            <li class="menu-item px-3">
                                                <Link
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                    :href="`/category/${category.id}/edit`"><i
                                                    class="bi bi-pencil me-2"></i>Edit
                                                </Link>
                                            </li>

                                            <li class="menu-item px-3">
                                                <button @click="confirmDelete(
                                                    category.id, index
                                                )
                                                    "
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center">
                                                    <i class="bi bi-trash3 me-2"></i>Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <!--end::Action=-->
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="categories.meta">
                    <Pagination :links="categories.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
