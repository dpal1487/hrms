<script>

import { defineComponent } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url } from "@vuelidate/validators";
import ImageInput from '@/components/ImageInput.vue';
import AppLayout from "@/Layouts/AppLayout.vue";

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import axios from "axios";
import { toast } from "vue3-toastify";

export default defineComponent({
    props: ['user', 'isEdit', 'show', 'roles'],
    emits: ['hidemodal'],
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
                email: {
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
            showModal: false,
            isUploading: false,
            url: null,
            processing: false,
            form: this.$inertia.form({
                id: this.user?.data?.id || '',
                user_role: '',
                image: this.user?.data?.full_path || '',
                first_name: this.user?.data?.first_name || '',
                last_name: this.user?.data?.last_name || '',
                email: this.user?.data?.email || '',
                date_of_birth: this.user?.data?.date_of_birth || '',
                gender: this.user?.data?.gender || '',
            })
        }
    },
    components: {
        JetInput,
        JetLabel,
        InputError,
        VueDatePicker,
        ImageInput,
        Link,
        AppLayout

    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                this.form.transform((data) => ({
                    ...data,
                }))

                    .post(this.route("users.update", this.form.id), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                            this.processing = false

                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                            }
                        },
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
            formdata.append("id", this.user.data.id)

            this.isUploading = true;
            axios.post("/users/avatar-upload", formdata, {
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
    }
})

</script>

<template>
    <AppLayout>
        <!--begin::Modal body-->
        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

            <!--begin::Form-->
            <form @submit.prevent="submit()" class="form">
                <!--begin::Scroll-->

                <!--begin::Input group-->
                <div class="mb-7">
                    <!--begin::Label-->
                    <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                    <!--end::Label-->
                    <!--begin::Image input-->
                    <ImageInput :image="this.user?.data?.full_path" :onchange="onFileChange" :remove="removeSelectedAvatar"
                        :selectedImage="url" :isUploading="isUploading" />
                    <!--end::Image input-->
                    <!--begin::Hint-->
                    <div class="form-text">Allowed file types: png, jpg, jpeg.
                    </div>
                    <!--end::Hint-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row">
                    <div class="mb-7 col-6">
                        <!--begin::Label-->
                        <jet-label for="first_name" value="First Name" />
                        <jet-input id="first_name" type="text" v-model="v$.form.first_name.$model" :class="v$.form.first_name.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="First Name" />
                        <div v-for="(error, index) of v$.form.first_name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>

                    <div class="mb-7 col-6">
                        <!--begin::Label-->
                        <jet-label for="last_name" value="Last Name" />
                        <jet-input id="last_name" type="text" v-model="v$.form.last_name.$model" :class="v$.form.last_name.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="Last Name" />
                        <div v-for="(error, index) of v$.form.last_name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row">
                    <div class="mb-7 col-6">
                        <!--begin::Label-->
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="text" v-model="v$.form.email.$model" :class="v$.form.email.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="Email" />
                        <div v-for="(error, index) of v$.form.email.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-6 mb-7">
                        <jet-label value="Date Of Birth" />

                        <VueDatePicker v-model="v$.form.date_of_birth.$model" :enable-time-picker="false" auto-apply
                            input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.date_of_birth.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " placeholder="Date Of Joining"></VueDatePicker>
                        <div v-for="(error, index) of v$.form.date_of_birth.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
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

                <!--begin::Input group-->
                <div class="mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-5">Role</label>
                    <!--end::Label-->
                    <!--begin::Roles-->
                    <!--begin::Input row-->
                    <div v-for="(role, index) in roles.data" :key="index">
                        <div class="d-flex fv-row">
                            <!--begin::Radio-->
                            <div class="form-check form-check-custom form-check-solid">
                                <!--begin::Input-->
                                <input class="form-check-input me-3" v-model="form.user_role" type="radio" name="user_role"
                                    id="kt_modal_update_role_option_0" />
                                <!--end::Input-->
                                <!--begin::Label-->
                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                    <div class="fw-bold text-gray-800 text-capitalize">{{ role.name }}
                                    </div>
                                    <div class="text-gray-600">Best for business
                                        owners and company administrators</div>
                                </label>
                                <!--end::Label-->
                            </div>
                            <!--end::Radio-->
                        </div>
                        <!--end::Input row-->
                        <div class='separator separator-dashed my-5'></div>
                    </div>

                    <!--end::Roles-->
                </div>
                <!--end::Input group-->
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="text-center pt-15 gap-5">
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                    <button type="submit" class="btn btn-primary" :data-kt-indicator="form.processing ? 'on' : 'off'">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal body-->
    </AppLayout>
</template>