<script>
import { defineComponent } from 'vue';

import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import InputError from "@/jetstream/InputError.vue";
import Modal from '@/Components/Modal.vue';
import { toast } from 'vue3-toastify';
import axios from 'axios';


export default defineComponent({

    props: ['permission', 'isEdit', 'show',],
    emits: ['hidemodal'],

    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            form: {
                name: {
                    required
                }
            }
        }

    },

    data() {
        return {
            processing: false,
            showModal: false,
            form: this.$inertia.form({
                id: this.permission?.id || '',
                name: this.permission?.name || '',

            }),
        }
    },
    components: {
        JetInput,
        InputError,
        Modal

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
                if (this.isEdit) {

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
            }
        }
    }

})
</script>

<template>
    <Modal :show="show" :title="isEdit ? 'Edit Permission' : 'Add Permission'" @onhide="$emit('hidemodal', false)">

        <!--begin::Form-->
        <form @submit.prevent="submit()" class="form">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold form-label mb-2">
                    <span class="required">Permission Name</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover"
                        data-bs-html="true" data-bs-content="Permission names is required to be unique."></i>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="First name" />
                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
                <!--end::Input-->
            </div>
            <!--end::Input group-->

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


    </Modal>
</template>