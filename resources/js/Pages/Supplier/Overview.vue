<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import PrimaryButton from "@/Jetstream/Button.vue";

export default defineComponent({
    props: ['supplier', 'address', 'company'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                company_id: {
                    required,
                },
                supplier_name: {
                    required,
                },
                display_name: {
                    required,
                },
                website: {
                    required,
                },
                skype_profile: {
                    required,
                },
                linkedIn_profile: {
                    required,
                },
                description: {
                    required,
                },
                status: {
                    required,

                }

            }
        };
    },
    data() {
        return {
            isEdit: false,
            processing: false,
            form: this.$inertia.form({
                id: this.supplier?.data?.id || '',
                company_id: this.supplier?.data?.company?.id || '',
                supplier_name: this.supplier?.data?.supplier_name || '',
                display_name: this.supplier?.data?.display_name || '',
                website: this.supplier?.data?.website || '',
                skype_profile: this.supplier?.data?.skype_profile || '',
                linkedIn_profile: this.supplier?.data?.linkedIn_profile || '',
                description: this.supplier?.data?.description || '',
                status: this.supplier?.data?.status || '',
            }),
            status: [
                { name: 'Active', id: '1' },
                { name: 'Inactive', id: '0' },
            ]
        };
    },
    components: {
        AppLayout,
        Header,
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
                this.processing = true,
                    this.form.transform((data) => ({
                        ...data,
                    }))
                        .put(this.route('supplier.update', this.form.id),
                            {
                                onSuccess: (data) => {
                                    toast.success(this.$page.props.jetstream.flash.message);
                                    this.processing = false,
                                        this.isEdit = false;
                                },
                                onError: (data) => {
                                    toast.error(data.message)
                                },
                            });
            }
        },
    },
});
</script>
<template>
    <Head title="Supplier Overview"/>
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/supplier" class="text-muted text-hover-primary">Supplier</Link>
            </li>
        </template>
        <!--begin::Navbar-->
        <Header :supplier="supplier?.data" :address="address?.data" />
        <!-- {{ $page }} -->
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Manage Supplier </h3>
                    <!-- {{ supplier }} -->
                </div>
                <!--end::Card title-->
                <button class="btn btn-primary align-self-center" @click="this.isEdit = this.isEdit ? false : true"><i
                        class="bi bi-pencil me-2"></i>Edit Company
                </button>

                <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body">

                <!-- <Edit v-if="isEdit" :supplier="supplier" :company="company" /> -->
                <div class="row" v-if="isEdit">
                    <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="row g-5 col-md-12">
                            <div class="col-6">
                                <jet-label for="company_id" value="Company " />
                                <Multiselect id="company_id" :options="company" label="company_name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Comapny"
                                    v-model="form.company_id" track-by="name" :searchable="true" :class="v$.form.company_id.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.company_id.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>

                            </div>

                            <div class="col-6">
                                <jet-label for="supplier_name" value="Supplier Name" />
                                <jet-input id="supplier_name" type="supplier_name" v-model="v$.form.supplier_name.$model"
                                    :class="v$.form.supplier_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Supplier Name" />
                                <div v-for="(error, index) of v$.form.supplier_name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>

                            <div class="col-6">
                                <jet-label for="display_name" value="Display Name" />
                                <jet-input id="display_name" type="text" v-model="v$.form.display_name.$model" :class="v$.form.display_name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Enter supplier Display Name" />
                                <div v-for="(error, index) of v$.form.display_name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="website" value="Website" />
                                <jet-input id="website" type="text" v-model="v$.form.website.$model" :class="v$.form.website.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Website" />
                                <div v-for="(error, index) of v$.form.website.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="skype_profile" value="Skype Profile" />
                                <jet-input id="skype_profile" type="text" v-model="v$.form.skype_profile.$model" :class="v$.form.skype_profile.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Skype Profile" />
                                <div v-for="(error, index) of v$.form.skype_profile.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>

                            <div class="col-6">
                                <jet-label for="linkedIn_profile" value="LinkedIn Profile" />
                                <jet-input id="linkedIn_profile" type="text" v-model="v$.form.linkedIn_profile.$model"
                                    :class="v$.form.linkedIn_profile.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="LinkedIn Profile" />
                                <div v-for="(error, index) of v$.form.linkedIn_profile.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="description" value="Description" />
                                <jet-input id="description" type="text" v-model="v$.form.description.$model" :class="v$.form.description.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Description" />
                                <div v-for="(error, index) of v$.form.description.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>

                            <div class="col-6">
                                <jet-label for="status" value="Status" />
                                <Multiselect :options="status" label="name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="form.status" track-by="name" :class="v$.form.status.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>

                            </div>

                        </div>
                        <!--end::Variations-->
                        <div class="row text-align-center p-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-5">
                                    <button type="button" class="btn btn-outline-secondary me-5"
                                        @click="this.isEdit = false">Discard</button>
                                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                        :data-kt-indicator="processing ? 'on' : 'off'">
                                        <span class="indicator-label">
                                            <span>Save Changes</span>
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </form>

                </div>
                <div v-else>
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Company Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.company?.company_name
                            }}
                            </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Supplier Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.supplier_name }}
                            </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Display Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.display_name }}
                            </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Website
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.website }} </span>

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Skype ID</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-700">{{
                                this.supplier?.data?.skype_profile }} </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Linked Profile ID</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.linkedIn_profile
                            }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Description</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.description }}</span>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Status</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-700" v-if="this.supplier?.data?.status == 1">Active</span>
                            <span class="fw-bold fs-6 text-gray-700" v-if="this.supplier?.data?.status == 0">Inactive</span>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            <!--end::Card body-->
        </div>

        <!--end::details View-->
    </AppLayout>
</template>
