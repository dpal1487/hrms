<script>
import { defineComponent } from 'vue';

import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import Multiselect from "@vueform/multiselect";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

import PlanDescriptionForm from './PlanDescriptionForm.vue';
export default defineComponent({
    props: ['plan', 'categories'],
    emits: ['submitted'],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {

            form: {
                name: { required },
                price: { required },
                category: { required },
                no_of_ads: { required },
                currency: { required },
                status: { required },
                plan_id: { required },
                description: {},
                sort_description: {},
                sort_order: { required },
            }
        }

    },
    data() {
        return {
            editor: ClassicEditor,
            descriptions: [],
            rowCount: 1,
            items: 1,
            processing: false,
            form: this.$inertia.form({
                id: this.plan?.data?.id || '',
                name: this.plan?.data?.name || '',
                category: this.plan?.data?.category?.id || '',
                plan_id: this.plan?.data?.plan_id || '',
                no_of_ads: this.plan?.data?.type || '',
                sort_description: this.plan?.data?.sort_description || '',
                description: this.plan?.data?.description || '',
                status: this.plan?.data?.status || '',
                price: this.plan?.data?.price || '',
                currency: this.plan?.data?.currency || '',
                sort_order: this.plan?.data?.sort_order || '',
                plan_description: [{
                    description: '',
                }],
            }),
            status: [
                { value: '1', label: 'Active' },
                { value: '0', label: 'Inactive' },
            ],

        }
    },
    components: {
        JetInput,
        InputError,
        JetLabel,
        JetValidationErrors,
        Multiselect,
        PlanDescriptionForm
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.$emit('submitted', this.form)
            }
        },
    }
})
</script>
<template>
    <JetValidationErrors />
    <form @submit.prevent="submit" autocomplete="off">
        <!--begin::Input group-->

        <div class="row g-5 mb-5">
            <div class="fv-row col-6">
                <!--begin::Label-->
                <jet-label for="name" value="Name" class="required" />
                <!--end::Label-->
                <!--begin::Input-->
                <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Name" />
                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6">
                <!--begin::Label-->
                <jet-label for="price" value="Price" class="required" />
                <!--end::Label-->
                <!--begin::Input-->
                <jet-input id="price" type="text" v-model="v$.form.price.$model" :class="v$.form.price.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Price" />
                <div v-for="(error, index) of v$.form.price.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6">
                <!--begin::Label-->
                <jet-label for="plan_id" value="Plan Id" class="required" />
                <!--end::Label-->
                <!--begin::Input-->
                <jet-input id="Plan Id" type="text" v-model="v$.form.plan_id.$model" :class="v$.form.plan_id.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="plan_id" />
                <div v-for="(error, index) of v$.form.plan_id.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>

            <div class="fv-row col-6">
                <div class="">
                    <jet-label for="category_id" value="Category" class="required" />
                    <Multiselect :options="categories" label="name" valueProp="id"
                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                        v-model="v$.form.category.$model" track-by="name" :searchable="true" :class="v$.form.category.$errors.length > 0
                            ? 'is-invalid'
                            : ''" />
                    <div v-for="(error, index) of v$.form.category.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>


            <div class="fv-row col-6">
                <!--begin::Label-->
                <jet-label for="no_of_ads" value="Number Of Adds" class="required" />
                <!--end::Label-->
                <!--begin::Input-->
                <jet-input id="no_of_ads" type="text" v-model="v$.form.no_of_ads.$model" :class="v$.form.no_of_ads.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Number Of Adds" />
                <div v-for="(error, index) of v$.form.no_of_ads.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6">
                <!--begin::Label-->
                <jet-label for="currency" value="Currency" class="required" />
                <!--end::Label-->
                <!--begin::Input-->
                <jet-input id="currency" type="text" v-model="v$.form.currency.$model" :class="v$.form.currency.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Currency" />
                <div v-for="(error, index) of v$.form.currency.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>


            <div class="fv-row col-6">
                <jet-label for="sort_order" value="Sort Order" class="required" />
                <!--end::Label-->
                <div class="">
                    <!--begin::Input-->
                    <jet-input id="sort_order" type="text" v-model="v$.form.sort_order.$model" :class="v$.form.sort_order.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Sort Order" />
                    <div v-for="(error, index) of v$.form.sort_order.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="fv-row col-6">
                <jet-label for="department_id" value="Status" class="required" />
                <Multiselect :options="status" label="label" valueProp="value"
                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                    v-model="v$.form.status.$model" track-by="label" :class="v$.form.status.$errors.length > 0
                        ? 'is-invalid'
                        : ''" />
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
        <slot name="action"></slot>
    </form>
</template>