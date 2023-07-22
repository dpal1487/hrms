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
                attribute_rules: {},
            },
        };
    },
    data() {
        return {
            rowCount: 1,
            attribute_rules: 1,
            isEdit: false,
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
                attribute_rules: this.attribute?.data?.rules || [],
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
    },
    methods: {

        addAttribute(rowCount) {
            for (var i = 0; i < rowCount; i++) {
                this.form.attribute_rules.push({
                    rules: '',
                });
            }
        },
        removeAttribute(index) {
            if (this.form.attribute_rules.length > 1) {
                this.form.attribute_rules.splice(index, 1)
            }
        },
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'attribute.create' ? this.route("attribute.store") : this.route('attribute.update', this.form.id), {
                        onSuccess: (data) => {
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
        },
    },

    created() {
        if (route().current() == 'attribute.edit') {
            this.isEdit = true;
        }
        else {
            this.form.attribute_rules = [{
                rules: '',
            }]
        }
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
                <span class="text-muted">Attribute Form</span>
            </li>
        </template>
        <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row gap-5">
            <div class="d-flex col-12 col-lg-8 flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card">
                    <div class="card-header align-items-center">
                        <div class="card-title">
                            <h2>Attribute</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <jet-label for="name" value="Name" class="required" />
                            <div class="">
                                <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Attribute Name" />
                                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <jet-label for="department_id" value="Category" class="required" />
                                <Multiselect :canClear="false" :options="categories?.data" label="name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.category.$model" track-by="name" />
                                <div v-for="(error, index) of v$.form.category.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="department_id" value="Input Type" class="required" />
                                <Multiselect :canClear="false" :options="input_type" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.input_type.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.input_type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <jet-label value="Data Type" class="required" />
                                <Multiselect :canClear="false" :options="data_type" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.data_type.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.data_type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label value="Display Order" class="required" />
                                <Multiselect :canClear="false" :options="display_order" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.display_order.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.display_order.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <jet-label for="field" value="Field" class="required" />
                                <div class="">
                                    <jet-input id="field" type="text" v-model="v$.form.field.$model" :class="v$.form.field.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Attribute Field" />
                                    <div v-for="(error, index) of v$.form.field.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="department_id" value="Status" class="required" />
                                <Multiselect :canClear="false" :options="status" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.status.$model" track-by="label" />
                                <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="fv-row">
                            <jet-label for="description" value="Description" />
                            <textarea id="description" v-model="v$.form.description.$model"
                                class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Text ..." />
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex col-12 col-lg-4 flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Attribute Rule</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-for='(attr, index) in form.attribute_rules' class="d-flex align-items-center mb-6">
                            <div class="w-100 position-relative">
                                <Multiselect :canClear="false" :options="rules?.data" label="rule" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="attr.id" track-by="label" />
                                <div v-for="(error, index) of v$.form.attribute_rules.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <button type="button" @click="removeAttribute(index)"
                                class="btn btn-sm btn-icon btn-light-danger ms-4">
                                <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 15 15" height="1em"
                                    width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-time="evenodd" clip-time="evenodd"
                                        d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
                                        fill="currentColor"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-5">
                            <button type="button" @click="addAttribute(this.rowCount)" class="btn btn-sm btn-light-primary">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                                </svg>
                                Add More
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-5">
                    <Link href="/attributes"
                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-if="route().current() == 'attribute.edit'">Update</span>
                        <span v-if="route().current() == 'attribute.create'">Save</span>
                    </button>
                </div>
            </div>
        </form>
    </AppLayout>
</template>
