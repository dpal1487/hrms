<script>
import { defineComponent } from 'vue';
import { required } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import InputError from "@/jetstream/InputError.vue";
import Modal from '@/Components/Modal.vue';
import { toast } from 'vue3-toastify';
import axios from 'axios';
import useVuelidate from '@vuelidate/core';

export default defineComponent({

    props: ['isEdit', 'show', 'permissions', 'role'],
    emits: ['hidemodal'],

    setup() {
        return {
            v$: useVuelidate()

        }
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                }

            }

        }
    },
    data() {
        return {
            showModal: false,
            processing: false,
            form: this.$inertia.form({
                id: this.role?.id || '',
                name: this.role?.name || '',
                read: this.role?.read || '',
                write: this.role?.write || '',
                create: this.role?.create || '',
                delete: this.role?.delete || '',
            }),
        }
    },
    components: {
        Modal,
        JetInput,
        InputError,

    },
    methods: {
        submit() {

            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                if (!this.isEdit) {
                    axios.post(this.route("roles.store"), this.form)
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
                if (this.isEdit) {
                    axios.put(this.route('roles.update', this.form.id), this.form)
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
            }
        }
    }

})
</script>

<template>
    <Modal :show="show" :title="isEdit ? 'Edit Role' : 'Add Role'" @onhide="$emit('hidemodal', false)">

        <!--begin::Modal body-->
        <div class="modal-body scroll-y mx-lg-5">
            <!--begin::Form-->
            <form @submit.prevent="submit()" class="form">
                <!--begin::Scroll-->
                <div class="d-flex flex-column scroll-y" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                    data-kt-scroll-offset="300px">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">Role name</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="Enter a role name" />
                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Permissions-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                        <!--end::Label-->
                        <!--begin::Table wrapper-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Administrator Access
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                title="Allows a full access to the system"></i>
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" v-model="read"
                                                    id="roles_select_all" />
                                                <span class="form-check-label" for="roles_select_all">Select
                                                    all</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr v-for="(permission, index) in permissions" :key="index">
                                        <!--begin::Label-->
                                        <td class="text-gray-800 text-uppercase">{{ permission.name }}</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                {{ permissions.read }}
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-8">
                                                    <input class="form-check-input" type="checkbox"
                                                        :value="permission.name + '-read'"
                                                        :name="permission.name + '-read[]'" v-model="form.read" />
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-8">
                                                    <input class="form-check-input" type="checkbox" v-model="form.write"
                                                        name="write[]" />
                                                    <span class="form-check-label">Write</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid  me-5 me-lg-8">
                                                    <input class="form-check-input" type="checkbox" v-model="form.create"
                                                        name="create[]" />
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" v-model="form.delete"
                                                        name="delete[]" />
                                                    <span class="form-check-label">Delete</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table wrapper-->
                    </div>
                    <!--end::Permissions-->
                </div>
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <button type="reset" class="btn btn-light me-3" @onhide="$emit('hidemodal', false)">Discard</button>
                    <button type="submit" class="btn btn-primary" :data-kt-indicator="processing ? 'on' : 'off'">
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