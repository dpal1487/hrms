<script>
import { defineComponent, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, integer } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import PlanList from "./Components/PlanList.vue";
export default defineComponent({
    props: ['plan', 'categories', 'currencies', 'times'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: { required },
                price: { required },
                category: { required },
                no_of_ads: { required, integer },
                currency: { required },
                status: { required },
                period: { required },
                description: {},
                sort_description: {},
                sort_order: { required },
            },
        };
    },
    data() {
        return {
            rowCount: 1,
            plan_descriptions: 1,
            isEdit: false,
            editor: ClassicEditor,
            requesting: false,
            form: this.$inertia.form({
                id: this.plan?.data?.id || '',
                name: this.plan?.data?.name || '',
                category: this.plan?.data?.category?.id || '',
                period: this.plan?.data?.period || '',
                no_of_ads: this.plan?.data?.type || '',
                sort_description: this.plan?.data?.sort_description || '',
                description: this.plan?.data?.description || '',
                status: this.plan?.data?.status || '',
                price: this.plan?.data?.price || '',
                currency: this.plan?.data?.currency || '',
                sort_order: this.plan?.data?.sort_order || '',
                plan_descriptions: [{
                    description: '',
                }],
            }),
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
        PlanList
    },
    methods: {

        addPlanDescriptionForm(rowCount) {
            for (var i = 0; i < rowCount; i++) {
                this.form.plan_descriptions.push({
                    description: '',
                });
            }
        },
        removePlanDescriptionForm(index) {
            if (this.form.plan_descriptions.length > 0) {
                this.form.plan_descriptions.splice(index, 1)
            }
        },
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'plan.create' ? this.route("plan.store") : this.route('plan.update', this.form.id), {
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

        },
    },
    created() {
        if (route().current() == 'plan.edit') {
            this.isEdit = true;
        }
    },
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Plan' : `Add New Plan`" />

    <AppLayout :title="isEdit ? 'Edit Plan' : `Add New Plan`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/plans" class="text-muted text-hover-primary">Plans</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Plan Form</span>
            </li>
        </template>
        <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row gap-5">
            <div class="d-flex col-12 col-lg-8 flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Plan</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
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
                                <div class="">
                                    <jet-label for="category_id" value="Category" class="required" />
                                    <Multiselect :options="categories?.data" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.category.$model" track-by="name" :searchable="true" :class="v$.form.status.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.category.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row col-6">
                                <div class="">
                                    <jet-label for="time_id" value="Time Period" class="required" />
                                    <Multiselect id="time_id" :options="times?.data" label="title" valueProp="title"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.period.$model" track-by="name" :searchable="true" :class="v$.form.period.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.period.$errors" :key="index">
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
                                <div class="">
                                    <jet-label for="currency-id" value="Currency" class="required" />
                                    <Multiselect id="currency-id" :options="currencies?.data" label="name" valueProp="code"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.currency.$model" track-by="code" :searchable="true" :class="v$.form.currency.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.currency.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
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
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <jet-label for="description" value="Description" />
                            <div class="mx-3">

                                <textarea id="description" :editor="editor" v-model="v$.form.sort_description.$model"
                                    class="form-control form-control-solid" :class="v$.form.sort_description.$errors.length > 0
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
                            <h2>Plan Description</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div>
                            <!--begin::Form group-->
                            <div class="">
                                <div>
                                    <div class="row align-items-center">
                                        <PlanList :plan="plan" :form="form" @removeSingle="removePlanDescriptionForm" />

                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <!--begin::Button-->
                                <button type="button" @click="addPlanDescriptionForm(this.rowCount)"
                                    class="btn btn-sm btn-light-primary">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                                    </svg>
                                    Add More
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-5">
                    <Link href="/plans" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                        :data-kt-indicator="form.processing ? 'on' : 'off'">
                        <span class="indicator-label">

                            <span v-if="route().current() == 'plan.edit'">Save Changes</span>
                            <span v-if="route().current() == 'plan.create'">Save</span>
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
