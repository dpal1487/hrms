<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import TopCard from "./Components/TopCard.vue";
import AttributeValueList from "./Components/Attribute/AttributeValueList.vue";
import AttributeValueForm from "./Components/Attribute/AttributeValueForm.vue";
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
            id: route.params,
            // id: this.attribute?.data?.id,
            filter: {

            },
            tbody: [
                "Attribute Value",
                "Attribute Status",
                "Action",
            ],
            isEdit: false,
            isAdd: false,
            form: {
                processing: false,
            },
            isLoading: false,
            title: "Attbute Value",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        TopCard,
        AttributeValueList,
        AttributeValueForm,
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
                .post(this.isAdd ? this.route("attribute-value.store") : this.route('attribute-value.update', this.attribute?.data?.id), {
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
        toggleModal(isEdit, attribute) {
            this.isEdit = isEdit;
            this.form = attribute;
        },
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('attribute-value.destroy', id), this.attribute?.data?.values, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get(
                "/attribute/" + this.id,
                this.filter,
            );
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
                <Link href="/attributes" class="text-muted text-hover-primary">Attributes</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Attribute Overview
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/attribute/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Attribute</Link>
            </div>
        </template>
        <div class="mb-5">
            <TopCard :attribute="attribute?.data" />
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Attribute List</h2>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div>
                            <form @submit.prevent="search()">
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
                                    <input type="text" v-model="filter.q"
                                        class="form-control form-control-solid h-35px w-200px ps-14"
                                        placeholder="Search " />
                                </div>
                            </form>
                        </div>
                        <button class="btn btn-primary m-1 btn-sm" v-if="!isEdit"
                            @click="this.isAdd = this.isAdd ? false : true, this.form = {}"><i
                                class="bi bi-plus-circle"></i>Add New
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" v-if="isEdit || isAdd">
                        <div class="col-6 mx-10">
                            <attribute-value-form @submitted="submit" :attribute="form" :id="attribute?.data?.id">
                                <template #action>
                                    <div class="d-flex justify-content-end me-5">
                                        <button type="button" class="btn btn-outline-secondary me-5"
                                            @click="this.isEdit = false, this.isAdd = false">Discard</button>
                                        <button type="submit" class="btn btn-primary"
                                            :class="{ 'text-white-50': form.processing }">
                                            <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span v-if="isAdd">
                                                Save
                                            </span>
                                            <span v-if="isEdit">
                                                Update
                                            </span>
                                        </button>
                                    </div>
                                </template>
                            </attribute-value-form>
                        </div>
                    </div>
                    <div class="row" v-else>
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
