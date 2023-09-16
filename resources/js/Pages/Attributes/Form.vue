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
                categories: { required },
                input_type: { required },
                data_type: { required },
                display_order: { required },
                field: { required },
                status: { required },
                description: {},
                rules: {},
            },
        };
    },
    data() {
        return {
            isEdit: false,
            form: this.$inertia.form({
                id: this.attribute?.data?.id || '',
                name: this.attribute?.data?.name || '',
                category: this.attribute?.data?.category?.id || '',
                input_type: this.attribute?.data?.input_type || '',
                data_type: this.attribute?.data?.data_type || '',
                display_order: this.attribute?.data?.display_order || '',
                field: this.attribute?.data?.field || '',
                status: this.attribute?.data?.status || '',
                description: this.attribute?.data?.description || '',
                rules: this.attribute?.data?.rules.map(rule => rule.id) || [],
                categories: this.attribute?.data?.categories.map(category => category?.id) || [],

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
    },
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
                            <h2>Attribute Form</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-6">
                                <jet-label for="name" value="Brand Name" class="required" />
                                <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Attribute Name" />
                                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="rules" value="Attribute Rule" />
                                <Multiselect id="rules" :can-clear="false" :options="rules?.data" label="rule"
                                    valueProp="id" class="form-control form-control-solid" placeholder="Attibute Rule"
                                    mode="tags" :close-on-select="false" track-by="rule" :searchable="true"
                                    :create-option="true" :class="v$.form.rules.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " v-model="v$.form.rules.$model" />
                                <div v-for="(error, index) of v$.form.rules
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">

                                <jet-label value="Category" class="required" />
                                <Multiselect :canClear="false" :options="categories?.data" label="name" valueProp="id" mode="tags" :close-on-select="false" :create-option="true"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Category" :searchable="true"
                                    v-model="v$.form.categories.$model" track-by="name" :class="v$.form.categories.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.categories.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label value="Input Type" class="required" />
                                <Multiselect :canClear="false" :options="input_type" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Input Type"
                                    v-model="v$.form.input_type.$model" track-by="label" :class="v$.form.input_type.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.input_type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <jet-label value="Data Type" class="required" />
                                <Multiselect :canClear="false" :options="data_type" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Data Type"
                                    v-model="v$.form.data_type.$model" track-by="label" :class="v$.form.data_type.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.data_type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label value="Display Order" class="required" />
                                <Multiselect :canClear="false" :options="display_order" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Display Order"
                                    v-model="v$.form.display_order.$model" track-by="label" :class="v$.form.display_order.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.display_order.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <jet-label value="Brand Field" class="required" />
                                <div class="">
                                    <jet-input  type="text" v-model="v$.form.field.$model" :class="v$.form.field.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Brand Field" />
                                    <div v-for="(error, index) of v$.form.field.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label  value="Status" class="required" />
                                <Multiselect :canClear="false" :options="status" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Status"
                                    v-model="v$.form.status.$model" track-by="label" :class="v$.form.status.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
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
