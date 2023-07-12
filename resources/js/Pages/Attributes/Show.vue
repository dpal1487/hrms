<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import TopCard from "./Components/TopCard.vue";
// import AttributeValueList from "./Components/AttributeValueList.vue";
import AttributeValueList from "./Components/Attribute/AttributeValueList.vue";
import AttributeValueForm from "./Components/Attribute/AttributeValueForm.vue";
import Multiselect from "@vueform/multiselect";
import InputError from "@/jetstream/InputError.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";

export default defineComponent({
    props: ["attribute", "attr"],
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
                .post(this.isAdd ? this.route("attribute-value.store", this.attribute?.data?.id) : this.route('attribute-value.update', this.attribute?.data?.id), {
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
                <Link class="text-muted text-hover-primary" href="/attribute">Attribute</Link>
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
                <!--begin::Primary button-->
                <Link href="/attribute/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Attribute</Link>
                <!--end::Primary button-->
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
                        <button class="btn btn-primary m-1 btn-sm" @click="this.isAdd = this.isAdd ? false : true"><i
                                class="bi bi-plus-circle"></i>Add New
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <div class="row" v-if="isEdit || isAdd">
                        <div class="col-12">
                            <attribute-value-form @submitted="submit" :attribute="form">
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
                            </attribute-value-form>
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
                                        <tr v-for="(attribute, index) in attribute?.data?.values" :key="index">
                                            <attribute-value-list :attribute="attribute">
                                                <template #action>
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                            :id="`dropdown-${attribute?.id}`" data-bs-toggle="dropdown"
                                                            aria-expanded="false">Actions <i class="bi bi-chevron-down"></i>
                                                        </a>
                                                        <ul class="dropdown-menu text-small menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                            :aria-labelled:by="`dropdown-${attribute?.id}`">
                                                            <li class="menu-item px-3">

                                                                <button
                                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                                    @click="toggleModal(true, attribute)"><i
                                                                        class="bi bi-pencil me-2"></i>Edit
                                                                </button>
                                                            </li>
                                                            <li class="menu-item px-3">
                                                                <button @click="confirmDelete(
                                                                    attribute?.id, index
                                                                )
                                                                    "
                                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center">
                                                                    <i class="bi bi-trash3 me-2"></i>Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
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
