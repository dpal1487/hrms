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

    props: ['company', 'show', 'countries'],
    setup() {
        return { v$: useVuelidate() };
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
                company_id: this.company?.data?.id,
                address_line_1: '',
                address_line_2: '',
                city: '',
                state: '',
                country: '',
                pincode: '',
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
                axios.post(this.route("company.address.store"), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            toast(response.data.message)
                            this.requesting = false;
                            this.$emit('hidemodal', false)
                            return;
                        } else {
                            toast(response.data.message)
                        }
                    });
            }
        },

    },
    created() {

    }

})
</script>

<template>
    <Modal :show="show" title="Add New Address" @onhide="$emit('hidemodal', false)">
        <JetValidationErrors />

        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin::Modal body-->
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


            </div>
            <div class="d-flex flex-end mt-5">
                <button type="reset" @click="$emit('hidemodal', false)" class="btn btn-light me-3">Discard</button>
                <button type="submit" class="btn btn-primary" :data-kt-indicator="requesting ? 'on' : 'off'">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </form>
    </Modal>
</template>
