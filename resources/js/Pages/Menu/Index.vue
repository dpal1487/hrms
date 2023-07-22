<script>
import { defineComponent } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
import MenuForm from './Components/MenuForm.vue';
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import utils from "../utils.js";

export default defineComponent({
    props: ['menu_lists'],
    emits: ['Onhide'],
    data() {
        return {
            item: [],
            title: "Menus",
            form: {},
            tbody: [
                "Menu",
                "Title",
                "Url",
                "Target",
                "Icon Class",
                "Color",
                "Parent",
                "Order By",
                "Route",
                "Parameters",
                "Action",
            ],
            isLoading: false,
            fullPage: true,

        }
    },
    components: {
        Head,
        AppLayout,
        MenuForm,
        Pagination,
        MenuForm,
        Link
    },
    methods: {

        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('menuItem.destroy', id), this.menu_lists.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get(
                "/faqs-categories",
                this.form,
            );
        },

        search() {
            Inertia.get(
                "/menu-items",
                this.form,

            );
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
                Menus
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/menu-item/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add Menu Item</Link>
            </div>
        </template>
        <div class="card card-flush">
            <div>
                <form class="card-header justify-content-start py-5 gap-4" @submit.prevent="search">
                    <div class="d-flex align-items-center position-relative">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-center">
                        <thead>
                            <tr class="text-gray-400 text-center fw-bold fs-7 min-w-100px text-uppercase">
                                <th class="min-w-100px" v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr class="text-center" v-for="(item, index) in menu_lists?.data" :key="index">
                                <td>{{ item.menu.name }}</td>
                                <td>{{ item.title }}</td>
                                <td>{{ item.url }}</td>
                                <td>{{ item.target || 'Null' }}</td>
                                <td>{{ item.icon_class }}</td>
                                <td>{{ item.color }}</td>
                                <td>{{ item.parent?.title || 'Null' }}</td>
                                <td>{{ item.order_by }}</td>
                                <td>{{ item.route }}</td>
                                <td>{{ item.parameters }}</td>
                                <td>
                                    <Link class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        :href="`/menu-item/${item.id}/edit`">
                                    <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                        item.id, index
                                    )
                                        ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="row" v-if="menu_lists.meta">
                    <div class="col-sm-12 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <Pagination :links="menu_lists.meta.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>