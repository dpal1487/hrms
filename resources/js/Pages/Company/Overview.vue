<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { toast } from "vue3-toastify";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import Multiselect from "@vueform/multiselect";

export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['company', 'corporationtypes', 'address'],
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        JetInput,
        JetLabel,
        InputError,
        Multiselect
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
                },
            },
        };
    },
    data() {
        return {
            processing: false,
            id: route().params.id,
            form: this.$inertia.form({
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
            isEdit: false,
            title: "Company Overview",
        };
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route("company.update"),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                console.log(data);
                            },
                        });
            }
        },
        changeStatus() {

        }
    },
    created() {
    }
});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">

        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/company" class="text-muted text-hover-primary">Compant</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ company.data.company_name }}
            </li>
        </template>
        <!--begin::Navbar-->
        <Header :company="company.data" />
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Company Details </h3>
                </div>
                <!--end::Card title-->
                <button class="btn btn-primary align-self-center" @click="this.isEdit = this.isEdit ? false : true"><i
                        class="bi bi-pencil me-2"></i>Edit Company
                </button>
            </div>
            <!--begin::Card body-->
            <div class="card-body p-9">
                <div class="row" v-if="isEdit">
                    <div class="col-12">
                        <form @submit.prevent="submit">
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label for="company-name" class="col-lg-4 col-form-label required fw-bold fs-6">Company
                                        Name</label>
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
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Company Type</label>
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
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Company Size</label>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                                        <span class="required">Corporation Type</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <Multiselect :options="corporationtypes.data" label="title" valueProp="id"
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Legal Registration No</label>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Description</label>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Website</label>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Subdomain</label>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Linkedin Profile</label>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Skype Profile</label>
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
                            <div class="d-flex justify-content-end mt-4">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-outline-secondary me-5"
                                    @click="this.isEdit = false">Discard</button>
                                <!--begin::Button-->
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else>
                    <!--begin::Input group-->
                    <div class="card-body p-9">
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">User Name</label>
                            <!--end::Label-->
                            <!-- {{ company?.data?.user }} -->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700"> {{ company?.data?.user?.first_name + " " +
                                    company?.data?.user.last_name }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Company Type</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700"> {{ company?.data?.company_type }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Company Size</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <span class="fw-bold text-gray-700 fs-6">{{ this.company?.data?.size.size }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Corporation Type</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700 me-2">{{ this.company?.data?.corporation_type_id }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Legal Registration_no</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.company?.data?.legal_registration_no
                                }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Description</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.company?.data?.description }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Website</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.company?.data?.website }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Subdomain</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.company?.data?.subdomain
                                }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Linkedin Profile</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.company?.data?.linkedin_profile
                                }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-6 fw-bold fs-5 text-gray-800">Skype Profile</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.company?.data?.skype_profile
                                }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </app-layout>
</template>
