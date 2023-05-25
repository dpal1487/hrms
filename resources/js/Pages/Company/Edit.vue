<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import axios from "axios";
import Header from "./Components/Header.vue";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ['company'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                company_name: {
                    required,
                },
                company_type: {
                    required,
                },
                company_size_id: {
                    required,
                },
                corporation_type_id: {
                    required,
                },
                legal_registration_no: {
                    required,
                },
                description: {
                    required,
                },
                website: {
                    required,
                },
                subdomain: {
                    required,
                },
                linkedin_profile: {
                    required,
                },
                skype_profile: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            processing: false,
            id: route().params.id,
            form: ({
                emp_id: route().params.id,
                id: this.company?.data.id || '',
                user_id: this.company?.data.user_id || '',
                company_name: this.company?.data?.company_name || '',
                company_type: this.company?.data?.company_type || '',
                company_size_id: this.company?.data?.company_size_id || '',
                corporation_type_id: this.company?.data?.corporation_type_id || '',
                legal_registration_no: this.company?.data?.legal_registration_no || '',
                description: this.company?.data?.description || '',
                website: this.company?.data?.website || '',
                subdomain: this.company?.data?.subdomain || '',
                linkedin_profile: this.company?.data?.linkedin_profile || '',
                skype_profile: this.company?.data?.skype_profile || '',
            }),
            corporation_type: [
                { id: '1', value: 'Corporation' },
                { id: '2', value: 'Sole Proprietorship' },
                { id: '3', value: 'Non - profit' },
                { id: '4', value: 'Limited Liability' },
                { id: '5', value: 'General Partnership' },
            ]
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,

        Header
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                axios.post(this.route("company.update"), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            toast.success(response.data.message)
                            this.processing = false
                            Inertia.get('/company')
                            return;
                        } else {
                            toast.error(response.data.message)
                        }
                    }).finally(() => {
                    });
            }
        },
    },
    created() {
    }
});
</script>
<template>
    <Head title="User company" />
    <AppLayout>
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header />

                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Edit Company</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <!--begin::Content-->
                    <div>
                        <!-- {{ company }} -->

                        <!--begin::Form-->
                        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label for="company-name"
                                        class="col-lg-4 col-form-label required fw-semibold fs-6">Company Name</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <jet-input id="company-name" type="text" v-model="v$.form.company_name.$model"
                                            :class="v$.form.company_name.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Company Type" />
                                        <div v-for="(error, index) of v$.form.company_name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company Type</label>
                                    <!--end::Label-->
                                    <input type="hidden" v-model="form.company_type">
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <jet-input id="company_type" type="text" v-model="v$.form.company_type.$model"
                                            :class="v$.form.company_type.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Company Type" />
                                        <div v-for="(error, index) of v$.form.company_type.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company Size</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="company_size_id" type="text" v-model="v$.form.company_size_id.$model"
                                            :class="v$.form.company_size_id.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Company Size" />
                                        <div v-for="(error, index) of v$.form.company_size_id.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>

                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Corporation Type</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <Multiselect :options="corporation_type" label="value" valueProp="id"
                                            class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                            v-model="v$.form.corporation_type_id.$model" track-by="name" :searchable="true"
                                            :class="v$.form.corporation_type_id.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.corporation_type_id.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Legal Registration No</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="legal_registration_no" type="text"
                                            v-model="v$.form.legal_registration_no.$model" :class="v$.form.legal_registration_no.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Legal Registration No" />
                                        <div v-for="(error, index) of v$.form.legal_registration_no.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="description" type="text" v-model="v$.form.description.$model" :class="v$.form.description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Description" />
                                        <div v-for="(error, index) of v$.form.description.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Website</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="website" type="text" v-model="v$.form.website.$model" :class="v$.form.website.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Website" />
                                        <div v-for="(error, index) of v$.form.website.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Subdomain</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="subdomain" type="text" v-model="v$.form.subdomain.$model" :class="v$.form.subdomain.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="subdomain" />
                                        <div v-for="(error, index) of v$.form.subdomain.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Linkedin Profile</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="linkedin_profile" type="text"
                                            v-model="v$.form.linkedin_profile.$model" :class="v$.form.linkedin_profile.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="linkedin_profile" />
                                        <div v-for="(error, index) of v$.form.linkedin_profile.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Skype Profile</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="skype_profile" type="text" v-model="v$.form.skype_profile.$model"
                                            :class="v$.form.skype_profile.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="skype_profile" />
                                        <div v-for="(error, index) of v$.form.skype_profile.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <Link :href="`/company`" class="btn btn-light btn-active-light-primary me-2">
                                Discard
                                </Link>
                                <!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button> -->
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span>Save</span>
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>
        </div>

    </AppLayout>
</template>
