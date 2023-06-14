<script>

import { defineComponent } from 'vue';
import Modal from '@/Components/Modal.vue';
import { Link } from "@inertiajs/inertia-vue3";
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
                id: '',
                user_role: '',
                image: this.user?.image?.medium_path || '',
                first_name: this.user?.first_name || '',
                last_name: this.user?.last_name || '',
                date_of_birth: this.user?.date_of_birth || '',
                gender: this.user?.gender || '',
            })
        }
    },
    components: {
        Modal,
        JetInput,
        JetLabel,
        InputError,
        VueDatePicker,
        ImageInput,
        Link,

    },
    methods: {
        submit() {

            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                if (!this.isEdit) {

                    axios.post(this.route("permission.store"), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                this.processing = false,
                                    this.$emit('hidemodal', false);
                                toast.success(response.data.message)
                                return
                            }
                            if (response.data.success == false) {
                                toast.error(response.data.message)
                            }
                        })
                }
                axios.put(this.route('permission.update', this.form.id), this.form)
                    .then((response) => {
                        if (response.data.success == true) {
                            this.processing = false,
                                this.$emit('hidemodal', false);
                            toast.success(response.data.message)
                            return
                        }
                        if (response.data.success == false) {
                            toast.error(response.data.message)
                        }
                    }).finally(() => {
                        return
                    });
            }
        }, onFileChange(e) {
            const file = e.target.files[0];

            this.$data.form.image = file;
            this.selectedFilename = file?.name;
            this.url = URL.createObjectURL(file);

            const formdata = new FormData();
            formdata.append("image", file)

            this.isUploading = true;
            axios.post("/avatar-upload", formdata, {
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
    <Modal :show="show" :title="isEdit ? 'Edit User' : 'Add User'" @onhide="$emit('hidemodal', false)">
        <!--begin::Modal body-->
        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
            <!--begin::Form-->
            <form @submit.prevent="submit()" class="form" action="#">
                <!--begin::Scroll-->
                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                        <!--end::Label-->
                        <!--begin::Image placeholder-->

                        <!--end::Image placeholder-->
                        <!--begin::Image input-->
                        <ImageInput :image="this.user?.full_path" :onchange="onFileChange" :remove="removeSelectedAvatar"
                            :selectedImage="url" :isUploading="isUploading" />


                        <!--end::Image input-->
                        <!--begin::Hint-->
                        <div class="form-text">Allowed file types: png, jpg, jpeg.
                        </div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Full
                            Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Full name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="example@domain.com" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-5">Role</label>
                        <!--end::Label-->
                        <!--begin::Roles-->
                        <!--begin::Input row-->
                        <div v-for="(role, index) in roles" :key="index">
                            <div class="d-flex fv-row">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3" v-model="form.user_role" type="radio"
                                        name="user_role" id="kt_modal_update_role_option_0" />
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
                </div>
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
    </Modal>
</template>