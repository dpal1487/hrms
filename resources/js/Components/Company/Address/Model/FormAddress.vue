<script>
import { defineComponent } from 'vue';
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import Modal from '../../../Modal.vue';
import { toast } from 'vue3-toastify';
import axios from 'axios';

export default defineComponent({

    props: ['show', 'countries', 'company', 'address', 'onOnhide'],
    emits: ['hidemodal'],


    setup() {
        return {
            v$: useVuelidate(),

        };
    },
    validations() {
        return {
            form: {
                address_line_1: {
                    required,
                },
                address_line_2: {
                    required,
                },
                city: {
                    required,
                },
                state: {
                    required,
                },
                country: {
                    required,
                },
                pincode: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            message: '',
            isEdit: false,
            requesting: false,

            form: this.$inertia.form({
                id: this.address?.id || '',
                company_id: this.company?.data?.id || '',
                address_line_1: this.address?.address_line_1 || '',
                address_line_2: this.address?.address_line_2 || '',
                city: this.address?.city || '',
                state: this.address?.state || '',
                country: this.address?.country.id || '',
                pincode: this.address?.pincode || '',
            }),
        };
    },

    components: {
        Modal,
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
    },
    methods:
    {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.requesting = true;
                axios.post(this.route("company.address.store"), { ...this.form, id: this.form.id })
                    .then((response) => {
                        if (response.data.success) {
                            toast(response.data.message)
                            this.requesting = false;
                            this.$emit('hidemodal', false);
                            location.reload();
                            return;
                        } else {
                            toast(response.data.message)
                        }
                    });
            }
        },

    }
})
</script>

<template>
    <Modal :show="show" title="Company Address" @onhide="$emit('hidemodal', false)">
        <!-- <Modal :show="show" title="Edit Address" @onhide="$emit('hidemodal', false)"> -->
        <JetValidationErrors />
        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::Modal body-->
            <!-- <input type="text" v-model="addressId"> -->
            <div class="me-n7 pe-7 mh-lg-400px" style="overflow-y: auto;">
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="address1" value="Address Line 1" />
                    <jet-input id="address1" type="text" v-model="v$.form.address_line_1.$model" :class="v$.form.address_line_1.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Address Line 1" />
                    <div v-for="(error, index) of v$.form.address_line_1.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="address2" value="Address Line 2" />
                    <jet-input id="address2" type="text" v-model="v$.form.address_line_2.$model" :class="v$.form.address_line_2.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Address Line 2" />
                    <div v-for="(error, index) of v$.form.address_line_2.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="city" value="City" />
                    <jet-input id="city" type="text" v-model="v$.form.city.$model" :class="v$.form.city.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="City" />
                    <div v-for="(error, index) of v$.form.city.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="state" value="State" />
                    <jet-input id="state" type="text" v-model="v$.form.state.$model" :class="v$.form.state.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="State" />
                    <div v-for="(error, index) of v$.form.state.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="pincode" value="Pincode" />
                    <jet-input id="pincode" type="text" v-model="v$.form.pincode.$model" :class="v$.form.pincode.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Pincode" />
                    <div v-for="(error, index) of v$.form.pincode.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="contry" value="Country" />
                    <Multiselect :options="countries" label="name" valueProp="id"
                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                        v-model="v$.form.country.$model" track-by="name" :searchable="true" :class="v$.form.country.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " />
                    <div v-for="(error, index) of v$.form.country.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>

                </div>
                <!--begin::Input group-->
                <div class="fv-row mb-5">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack">
                        <!--begin::Label-->
                        <div class="me-5">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold">Use as a billing adderess?</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Label-->
                        <!--begin::Switch-->
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            <!--begin::Input-->
                            <input class="form-check-input" name="billing" type="checkbox" value="1" v-model="isPrimary" checked="checked" />
                            <!--end::Input-->
                            <!--begin::Label-->
                            <span class="form-check-label fw-semibold text-muted">Yes</span>
                            <!--end::Label-->
                        </label>
                        <!--end::Switch-->
                    </div>
                    <!--begin::Wrapper-->
                </div>
                <!--end::Input group-->


            </div>
            <div class="d-flex flex-end mt-5">
                <button type="reset" @click="$emit('hidemodal', false)" class="btn btn-light me-3">Discard</button>
                <button type="submit" class="btn btn-primary" :data-kt-indicator="requesting ? 'on' : 'off'">
                    <span class="indicator-label">Save</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </form>
    </Modal>
</template>
