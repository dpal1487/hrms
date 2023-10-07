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
            isModalOpen: false,
            isLoading: false,
            showBrandForm: false,
            selectedBrand:null,
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
        addBrandValueModal() {
            this.showBrandForm = true;
            this.selectedBrand = null
        },
        editBrandValueModal(brand) {
            this.showBrandForm = true;
            this.selectedBrand = brand
        },
        hideBrandValueModal() {
            this.showBrandForm = false;
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
                <Link href="/brand/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Brand</Link>
            </div>
        </template>
        <div class="mb-5">
            <TopCard :brand="brand?.data" />
            
            <BrandModelForm :show="showBrandForm" :data="selectedBrand" :id="brand?.data?.id" @hidemodal="hideBrandValueModal" />
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Brand Model</h2>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end">
                        <div class="flex-1 fw-bold">
                            <button type="button" class="btn btn-primary m-1 btn-sm" @click="() => addBrandValueModal()"><i
                                    class="bi bi-plus-circle"></i>Add New
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12 mx-10">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-3 text-left">
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-6 text-uppercase">
                                            <th v-for="(th, index) in tbody" :key="index">
                                                {{ th }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="(brand, index) in brand?.data?.models" :key="index">
                                            <brand-model-list :brand="brand">
                                                <template #action>
                                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                                        @click="editBrandValueModal(brand)"><i
                                                            class="bi bi-pencil me-2"></i>
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
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                                v-if="brand.meta">
                                <!-- <Pagination :links="brand.meta.links" /> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
