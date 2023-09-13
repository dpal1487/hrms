<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import TopCard from "./Components/TopCard.vue";
import Multiselect from "@vueform/multiselect";
import InputError from "@/jetstream/InputError.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import utils from "../utils";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ["attribute"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                value: {
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
                "Attribute Value",
                "Attribute Status",
                "Action",
            ],
            title: "Category Overview",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        TopCard,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
    },
    methods: {
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
                <Link href="/categories" class="text-muted text-hover-primary">Categories</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Category Overview
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/category/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Category</Link>
            </div>
        </template>
        <div class="mb-5">
            <TopCard :attribute="attribute?.data" />
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Category Banner</h2>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mx-10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Category Attribute</h2>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mx-10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
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
                                        <tr v-for="(attribute, index) in attribute?.data?.values" :key="index">
                                            <attribute-value-list :attribute="attribute">
                                                <template #action>
                                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                                        @click="toggleModal(true, attribute)"><i
                                                            class="bi bi-pencil me-2"></i>
                                                    </button>

                                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                        @click="confirmDelete(
                                                            attribute.id, index
                                                        )
                                                            ">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </template>
                                            </attribute-value-list>
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
