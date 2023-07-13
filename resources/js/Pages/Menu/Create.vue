<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppToolbar from "../../Layouts/AppToolbar.vue";
import MenuItemForm from "./Components/MenuItemForm.vue";
import MenuForm from "./Components/MenuForm.vue";
import Swal from "sweetalert2";
import { toast } from 'vue3-toastify';

export default defineComponent({
    props: ["menu_lists", 'parents'],
    components: {
        AppLayout,
        Link,
        AppToolbar,
        Head,
        MenuItemForm,
        MenuForm,
    },
    data() {
        return {
            title: "Add Menu Item",
            isEdit: false,
            form: {},
            isModalOpen: false,
            menu: {}
        }
    },
    methods: {
        submit(form) {
            this.form = form;
            this.form
                .transform((data) => ({
                    ...data,
                }))
                .post(this.route('menuItem.store'), {
                    onSuccess: (data) => {
                        toast.success(this.$page.props.jetstream.flash.message);
                    },
                    onError: (data) => {

                    },
                });
        },
        showMenuModal() {
            this.isEdit = false;
            this.isModalOpen = true;
            this.menu = {}
        },
        hideMenuModal() {
            this.isModalOpen = false;
        },
        showEditMenuModal(menu) {
            this.isModalOpen = true;
            this.isEdit = true;
            this.menu = menu
        },
        confirmDelete(id, index) {
            this.isLoading = true;
            const name = this.menu_lists.data[index].name;
            Swal.fire({
                title: "Are you sure you want to delete " + name + " ?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(this.route('menu.destroy', id))
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.menu_lists.data.splice(index, 1);
                                return;
                            }
                        })
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: name + " was not deleted.",
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
    }
});
</script>
<template>
    <Head title="Add New Link" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="/menus" class="text-muted text-hover-primary">Menus</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Menu Item
            </li>
        </template>
        <MenuForm v-if="isModalOpen" :show="isModalOpen" :isEdit="isEdit" @hidemodal="hideMenuModal" :menu="menu" />
        <div class="row mb-5">
            <div class="col-8">
                <div class="card">
                    <div class="card-header align-items-center">
                        <div class="card-title">
                            <h2>Add Menu Item</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- end page title -->
                        <menu-item-form @submitted="submit" :menu_lists="menu_lists" :parents="parents">
                            <template #action>
                                <div class="d-flex justify-content-end">
                                    <!--begin::Button-->
                                    <Link type="button" class="btn btn-outline-secondary me-5" href="/menus">Discard
                                    </Link>
                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-primary"
                                        :class="{ 'text-white-50': form.processing }">
                                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        Save
                                    </button>
                                </div>
                            </template>
                        </menu-item-form>
                        <!-- end row -->
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header align-items-center">
                        <div class="card-title">
                            <h2>Menu List</h2>
                        </div>
                        <button @click="showMenuModal" class="btn btn-sm fw-bold btn-primary">
                            <i class="bi bi-plus-circle"></i>Add Menu</button>
                    </div>
                    <div class="card-body p-0">
                        <!-- end page title -->
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-gray-400 text-center fw-bold fs-7 min-w-100px text-uppercase">
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-semibold">
                                    <tr class="text-center" v-for="(menu, index) in menu_lists" :key="index">
                                        <!--begin::Name=-->
                                        <td class="text-bold">{{ menu.name }}</td>
                                        <!--begin::Action=-->
                                        <td>
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                                @click="showEditMenuModal(menu)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                                menu.id, index
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
                        <!--end::Table-->
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
