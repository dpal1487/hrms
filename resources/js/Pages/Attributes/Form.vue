<script>
import { defineComponent, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import AttributeList from "./components/AttributeList.vue";

export default defineComponent({
    props: ['attribute', 'categories', 'rules'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                image: {},
                name: { required },
                category: { required },
                input_type: { required },
                data_type: { required },
                display_order: { required },
                field: { required },
                status: { required },
                description: {},
            },
        };
    },
    data() {
        return {
            rowCount: 1,
            isEdit: false,
            editor: ClassicEditor,
            requesting: false,
            attributes: [],
            form: this.$inertia.form({
                id: this.attribute?.data?.id || '',
                name: this.attribute?.data?.name || '',
                category: this.attribute?.data?.category?.id || '',
                input_type: this.attribute?.data?.type || '',
                data_type: this.attribute?.data?.data_type || '',
                display_order: this.attribute?.data?.display_order || '',
                field: this.attribute?.data?.field || '',
                status: this.attribute?.data?.status || '',
                description: this.attribute?.data?.description || '',
            }),
            input_type: [
                { value: 'text', label: 'Text' },
                { value: 'number', label: 'Number' },
                { value: 'checkbox', label: 'Checkbox' },
                { value: 'radio', label: 'Radio' },
                { value: 'select', label: 'Select' },
            ],
            data_type: [
                { value: 'text', label: 'Text' },
                { value: 'number', label: 'Number' },
            ],
            display_order: [
                { value: 1, label: 'Yes' },
                { value: 0, label: 'No' },
            ],
            status: [
                { value: '1', label: 'Active' },
                { value: '0', label: 'Inactive' },
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        ClassicEditor,
        AttributeList
    },
    methods: {
        validateAttributes() {
            this.attributes = this.attributes.map(attr => {
                if (!Object.keys(attr).includes("rule")) {
                    return { ...attr, error: { message: "This field is required." } }
                }
                return attr;
            });
        },
        addAttribute() {
            this.attributes = [...this.attributes, { id: Date.now() }];
        },
        removeAttribute(id) {
            if (this.attributes.length > 1) {
                this.attributes = this.attributes.filter(attribute => attribute.id !== id);
            }
            return;
        },
        attributeOnChange(rule = {}) {
            this.attributes = this.attributes.map(attribute => {
                if (attribute.id === rule.id) {
                    return {
                        id: attribute.id,
                        rule: rule.value,
                    };
                }

                return attribute;
            })
        },

        submit() {
            this.validateAttributes();

            if (!this.attributes.find(a => Object.keys(a).includes("error"))) {
                let finalAttrbutes = this.attributes.map(a => ({ id: a.rule }));

                this.v$.$touch();
                if (!this.v$.form.$invalid) {
                    this.form
                        .transform((data) => ({
                            ...data,
                            finalAttrbutes
                        }))
                        .post(route().current() == 'attribute.create' ? this.route("attribute.store") : this.route('attribute.update', this.form.id), {
                            onSuccess: (data) => {
                                console.log(data);
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                }
                            },
                        });
                }
            }
        },
    },

    created() {
        if (route().current() == 'attribute.edit') {
            this.isEdit = true;
        }
        this.attributes = [{ id: Date.now() }];
    },
    mounted() {
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Attribute' : `Add New Attribute`" />

    <AppLayout :title="isEdit ? 'Edit Attribute' : `Add New Attribute`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/attributes" class="text-muted text-hover-primary">Attributes</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Attribute Form</span>
            </li>
        </template>

        <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row gap-5">
            <div class="d-flex col-12 col-lg-8 flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Attribute</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">

                        <div class="row g-3">
                            <div class="mb-10 row col-12">
                                <!--begin::Label-->
                                <jet-label for="name" value="Name" class="required" />
                                <!--end::Label-->
                                <div class="">
                                    <!--begin::Input-->
                                    <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Name" />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin::Input group-->
                        <div class="row g-3">
                            <div class="mb-10 fv-row col-6">
                                <div class="">
                                    <jet-label for="department_id" value="Category" class="required" />
                                    <Multiselect :options="categories?.data" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.category.$model" track-by="name" />
                                    <div v-for="(error, index) of v$.form.category.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-10 fv-row col-6">
                                <jet-label for="department_id" value="Input Type" class="required" />
                                <Multiselect :options="input_type" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.input_type.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.input_type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="mb-10 fv-row col-6">
                                <jet-label for="data-type" value="Data Type" class="required" />
                                <Multiselect :options="data_type" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.data_type.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.data_type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="mb-10 fv-row col-6">
                                <jet-label for="department_id" value="Display Order" class="required" />
                                <Multiselect :options="display_order" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.display_order.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.display_order.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>

                        </div>
                        <div class="row g-3">

                            <div class="mb-10 fv-row col-6">
                                <jet-label for="field" value="Field" class="required" />
                                <!--end::Label-->
                                <div class="">
                                    <!--begin::Input-->
                                    <jet-input id="field" type="text" v-model="v$.form.field.$model" :class="v$.form.field.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Attribute Field" />
                                    <div v-for="(error, index) of v$.form.field.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                            </div>
                            <div class="mb-10 fv-row col-6">
                                <jet-label for="department_id" value="Status" class="required" />
                                <Multiselect :options="status" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.status.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <jet-label for="description" value="Description" />
                            <div class="mx-3">

                                <ckeditor id="description" :editor="editor" v-model="v$.form.description.$model"
                                    class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Text ..." />
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Card header-->
                </div>

                <!--end::Meta options-->

            </div>
            <div class="d-flex col-12 col-lg-4 flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Attribute Rule</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div id="add_rule_conditions" data-select2-id="select2-data-kt_ecommerce_add_category_conditions">
                            <!--begin::Form group-->
                            <div class="">

                                <div>
                                    <div class="row align-items-center">
                                        <AttributeList @onChange="attributeOnChange" :options="rules?.data"
                                            @remove="removeAttribute" :attributes="attributes" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <!--begin::Button-->
                                <button type="button" @click="addAttribute()" class="btn btn-sm btn-light-primary">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                                    </svg>
                                    Add Rule
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-5">
                    <Link href="/attributes"
                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                        :data-kt-indicator="requesting ? 'on' : 'off'">
                        <span class="indicator-label">

                            <span v-if="route().current() == 'attribute.edit'">Save Changes</span>
                            <span v-if="route().current() == 'attribute.create'">Save</span>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>

        </form>
    </AppLayout>
</template>
