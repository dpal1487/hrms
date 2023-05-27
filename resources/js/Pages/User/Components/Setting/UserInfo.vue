<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import { Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url } from "@vuelidate/validators";
import ImageInput from '@/components/ImageInput.vue';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import axios from "axios";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";


// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ['employee', 'user'],

    setup() {
        return { v$: useVuelidate() };
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
            form: this.$inertia.form({
                id: this.user?.id || '',
                image: this.user?.image?.medium_path || '',
                image_id: '',
                first_name: this.user?.first_name || '',
                last_name: this.user?.last_name || '',
                date_of_birth: this.user?.date_of_birth || '',
                dark_mode: this.user?.dark_mode || '',
                gender: this.user?.gender || '',
            }),
            value: null,
            url: null,

        };
    },
    components: {
        AppLayout,
        Link,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        VueDatePicker,
        ImageInput,
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true,
                    axios.post(this.route('account.user.store'), this.form)
                        .then((response) => {
                            if (response.data.message) {
                                this.processing = false,
                                    toast.success(response.data.message)
                                Inertia.get('/account/setting')
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        })
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
    created() {

    }
});
</script>
<template>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile Details</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <!--begin::Form-->
        <form @submit.prevent="submit()" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
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
                        <ImageInput :image="this.user?.full_path" :onchange="onFileChange" :remove="removeSelectedAvatar"
                            :selectedImage="url" :isUploading="isUploading" />

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
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row g-3">
                            <!--begin::Col-->
                            <div class="col-lg-6  fv-plugins-icon-container">
                                <jet-input id="first_name" type="text" v-model="v$.form.first_name.$model" :class="v$.form.first_name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="First name" />
                                <div v-for="(error, index) of v$.form.first_name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6  fv-plugins-icon-container">
                                <jet-input id="last_name" type="text" v-model="v$.form.last_name.$model" :class="v$.form.last_name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Last name" />
                                <div v-for="(error, index) of v$.form.last_name.$errors" :key="index">
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
                    <div class="col-lg-8  fv-plugins-icon-container">
                        <VueDatePicker v-model="v$.form.date_of_birth.$model" :enable-time-picker="false" auto-apply
                            input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.date_of_birth.$errors.length > 0
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
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <!--begin::Options-->
                        <div class="d-flex align-items-center mt-3">
                            <!--begin::Option-->
                            <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                <input class="form-check-input" type="radio" value="male" name="gender"
                                    v-model="form.gender" />
                                <div class="form-check-label">
                                    Male
                                </div>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-custom form-check-inline form-check-solid">
                                <input class="form-check-input" type="radio" value="female" name="gender"
                                    v-model="form.gender" />
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
                    <div class="col-lg-8 d-flex align-items-center">
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
                <div class="col-12 gap-5">
                    <div class="d-flex justify-content-end gap-2">
                        <Link href="/account/setting"
                            class="btn btn-outline-secondary align-items-center justify-content-center">
                        Discard
                        </Link>
                        <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                            :data-kt-indicator="processing ? 'on' : 'off'">
                            <span class="indicator-label">
                                <span>Save</span>
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
        <!--end::Content-->
    </div>
</template>
