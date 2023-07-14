<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import TopCard from "./Components/TopCard.vue";
import BrandModelList from "./Components/Brand/BrandModelList.vue";
import BrandModelForm from "./Components/Brand/BrandModelForm.vue";
import Multiselect from "@vueform/multiselect";
import InputError from "@/jetstream/InputError.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import utils from "../utils";

export default defineComponent({
    props: ["brand"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                status: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            tbody: [
                "Name",
                "Status",
                "Action",
            ],
            isEdit: false,
            isAdd: false,
            form: {
                processing: false,
            },
            isLoading: false,
            title: "Brand Overview",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        TopCard,
        BrandModelList,
        BrandModelForm,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
    },
    methods: {
        submit(form) {
            this.form = form;
            this.form
                .transform((data) => ({
                    ...data,
                }))
                .post(this.isAdd ? this.route("brand-model.store") : this.route('brand-model.update', this.brand?.data?.id), {
                    onSuccess: (data) => {
                        toast.success(this.$page.props.jetstream.flash.message);
                        this.isEdit = false;
                        this.isAdd = false;
                    },
                    onError: (data) => {
                        toast.error(data.message);
                    },
                });
        },
        toggleModal(isEdit, brand) {
            this.isEdit = isEdit;
            this.form = brand;
        },
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('brand-model.destroy', id), this.brand?.data?.models, index);
            this.isLoading = false;
        },
    },
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
                <Link class="text-muted text-hover-primary" href="/brands">Brands</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Brand Overview
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <Link href="/brand/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Brand</Link>
                <!--end::Primary button-->
            </div>
        </template>
        <div class="mb-5">

            <TopCard :brand="brand?.data" />
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Brand Model</h2>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                        <button class="btn btn-primary m-1 btn-sm" v-if="!isEdit"
                            @click="this.isAdd = this.isAdd ? false : true, this.form = {}"><i
                                class="bi bi-plus-circle"></i>Add New
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <div class="row" v-if="isEdit || isAdd">

                        <div class="col-12">
                            <brand-model-form @submitted="submit" :brand="form" :id="brand?.data?.id">
                                <template #action>
                                    <div class="d-flex justify-content-end">
                                        <!--begin::Button-->
                                        <button type="button" class="btn btn-outline-secondary me-5"
                                            @click="this.isEdit = false, this.isAdd = false">Discard</button>
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-primary"
                                            :class="{ 'text-white-50': form.processing }">
                                            <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span v-if="isAdd">
                                                Save
                                            </span>
                                            <span v-if="isEdit">
                                                Save Changes
                                            </span>
                                        </button>
                                    </div>
                                </template>
                            </brand-model-form>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-1 text-center">
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-gray-800 fw-bold fs-7 text-uppercase">
                                            <th v-for="(th, index) in tbody" :key="index">
                                                {{ th }}
                                            </th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="(brand, index) in brand?.data?.models" :key="index">
                                            <brand-model-list :brand="brand">
                                                <template #action>
                                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                                        @click="toggleModal(true, brand)"><i class="bi bi-pencil me-2"></i>
                                                    </button>
                                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                        @click="confirmDelete(
                                                            brand.id, index
                                                        )
                                                            ">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </template>
                                            </brand-model-list>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
