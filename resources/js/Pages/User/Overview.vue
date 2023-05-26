<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { toast } from "vue3-toastify";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import useVuelidate from "@vuelidate/core";
import { required, email, url } from "@vuelidate/validators";
import Multiselect from "@vueform/multiselect";
import ImageInput from '@/components/ImageInput.vue';

export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['user', 'address'],

    components: {
        AppLayout,
        Header,
        Link,
        Head,
        JetInput,
        JetLabel,
        JetValidationErrors,
        InputError,
        Multiselect,
        ImageInput,
        VueDatePicker

    },
    validations() {
        return {
            form: {
                first_name: {
                    required,
                },
                last_name: {
                    required,
                },
                date_of_birth: {
                    required,
                },
                gender: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            isEdit: false,
            isUploading: false,
            processing: false,
            url: null,
            id: route().params.id,
            form: this.$inertia.form({
                id: this.user?.id || '',
                image: this.user?.data?.full_path || '',
                image_id: '',
                first_name: this.user?.data?.first_name || '',
                last_name: this.user?.data?.last_name || '',
                date_of_birth: this.user?.data?.date_of_birth || '',
                dark_mode: this.user?.data?.dark_mode || '',
                gender: this.user?.data?.gender || '',
            }),

            title: "Account Overview",
        };
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route("account.user.store"),
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
       
        onFileChange(e) {
            const file = e.target.files[0];
            this.$data.form.image = file;
            this.selectedFilename = file?.name;
            this.url = URL.createObjectURL(file);
            const formdata = new FormData();
            formdata.append("image", file)

            this.isUploading = true;
            axios.post("/account/avatar-upload", formdata, {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            }).then((response) => {
                if (response.data.success) {
                    // toast.success(response.data.message);
                    this.form.image_id = response.data.data.id;
                } else {
                    toast.error(response.data.message);
                }
            }).finally(() => {
                this.isUploading = false;
            })



        },
        removeSelectedAvatar() {
            this.url = null;
        }
    },

});
</script>
<template>
    <Head title="Account Overview" />
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/account" class="text-muted text-hover-primary">Account</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ user?.data?.first_name }}
            </li>
        </template>
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <!--begin::Navbar-->
                <Header :user="user.data" :address="address?.data" />
                <!-- {{ $page }} -->
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0"> Account Overview</h3>
                        </div>
                        <!--end::Card title-->
                        <button class="btn btn-primary align-self-center"
                            @click="this.isEdit = this.isEdit ? false : true"><i class="bi bi-pencil me-2"></i>Edit Account
                        </button>
                        <!-- <Link class="btn btn-primary align-self-center" href="/account/overview/edit">Edit
                        Account
                        </Link> -->
                        <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
                    </div>
                    <!--begin::Card header-->
                    <div class="card-body p-9">
                        <div class="row" v-if="isEdit">
                            <div class="col-12">
                                <JetValidationErrors />
                                <form @submit.prevent="submit()" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                    novalidate="novalidate">
                                    <!--begin::Card body-->
                                    <div class="card-body border-top p-9">
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-6">
                                                <!--begin::Image input-->
                                                <ImageInput :image="this.user?.data?.full_path" :onchange="onFileChange"
                                                    :remove="removeSelectedAvatar" :selectedImage="url"
                                                    :isUploading="isUploading" />

                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Full Name</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-6">
                                                <!--begin::Row-->
                                                <div class="row g-3">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-6  fv-plugins-icon-container">
                                                        <jet-input id="first_name" type="text"
                                                            v-model="v$.form.first_name.$model" :class="v$.form.first_name.$errors.length > 0
                                                                ? 'is-invalid'
                                                                : ''
                                                                " placeholder="First name" />
                                                        <div v-for="(error, index) of v$.form.first_name.$errors"
                                                            :key="index">
                                                            <input-error :message="error.$message" />
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-6  fv-plugins-icon-container">
                                                        <jet-input id="last_name" type="text"
                                                            v-model="v$.form.last_name.$model" :class="v$.form.last_name.$errors.length > 0
                                                                ? 'is-invalid'
                                                                : ''
                                                                " placeholder="Last name" />
                                                        <div v-for="(error, index) of v$.form.last_name.$errors"
                                                            :key="index">
                                                            <input-error :message="error.$message" />
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Date Of Birth</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-6  fv-plugins-icon-container">
                                                <VueDatePicker v-model="v$.form.date_of_birth.$model"
                                                    :enable-time-picker="false" auto-apply
                                                    input-class-name="form-control form-control-lg form-control-solid fw-normal"
                                                    :class="v$.form.date_of_birth.$errors.length > 0
                                                        ? 'is-invalid'
                                                        : ''
                                                        " placeholder="Date Of Joining"></VueDatePicker>
                                                <div v-for="(error, index) of v$.form.date_of_birth.$errors" :key="index">
                                                    <input-error :message="error.$message" />
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Gender</label>
                                            <!--end::Label-->

                                            <!--begin::Col-->
                                            <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                                <!--begin::Options-->
                                                <div class="d-flex align-items-center mt-3">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                                        <input class="form-check-input" type="radio" value="male"
                                                            name="gender" v-model="form.gender" />
                                                        <div class="form-check-label">
                                                            Male
                                                        </div>
                                                    </label>
                                                    <!--end::Option-->

                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-custom form-check-inline form-check-solid">
                                                        <input class="form-check-input" type="radio" value="female"
                                                            name="gender" v-model="form.gender" />
                                                        <div class="form-check-label">
                                                            Female
                                                        </div>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Options-->
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Col-->
                                        </div>

                                        <!--begin::Input group-->
                                        <div class="row mb-0">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Dark Mode</label>
                                            <!--begin::Label-->
                                            <!--begin::Label-->
                                            <div class="col-lg-6 d-flex align-items-center">
                                                <div class="form-check form-check-solid form-switch form-check-custom ">
                                                    <input class="form-check-input" type="checkbox" v-model="form.dark_mode"
                                                        valueProp="dark_mode" />
                                                    <label class="form-check-label" for="allowmarketing"></label>
                                                </div>
                                            </div>
                                            <!--begin::Label-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Actions-->

                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end mt-4">
                                                <!--begin::Button-->
                                                <button type="button" class="btn btn-outline-secondary me-5"
                                                    @click="this.isEdit = false">Discard</button>
                                                <!--begin::Button-->
                                                <button type="submit" class="btn btn-primary"
                                                    :class="{ 'text-white-50': form.processing }">
                                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                            </div>
                        </div>
                        <div v-else>
                            <!--begin::Input group-->
                            <div class="card-body p-9">
                                <!-- {{ user }} -->
                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-6 fw-bold fs-5 text-gray-800">Full Name</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <span class="fw-semibold fs-6 text-gray-800 ">{{ this.user?.data?.first_name }} {{
                                            this.user?.data?.last_name }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-6 fw-bold fs-5 text-gray-800">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6">{{ this.user?.data?.email }}
                                        </span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-6 fw-bold fs-5 text-gray-800">Date Of Birth</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6">{{ this.user?.data?.date_of_birth }}
                                        </span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-6 fw-bold fs-5 text-gray-800">Gender</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6">{{ this.user?.data?.gender }}
                                        </span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
