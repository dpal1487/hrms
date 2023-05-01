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

    props: ['show', 'company', 'account'],
    emits: ['hidemodal'],
    setup() {
        return {
            v$: useVuelidate(),

        };
    },
    validations() {
        return {
            form: {
                bank_name: {
                    required,
                },
                bank_address: {
                    required,
                },
                beneficiary_name: {
                    required,
                },
                account_number: {
                    required,
                },
                routing_number: {
                    required,
                },
                swift_code: {
                    required,
                },
                ifsc_code: {
                    required,
                },
                sort_code: {
                    required,
                },
                pan_number: {
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
                id: this.account?.id || '',
                company_id: this.company?.data?.id,
                bank_name: this.account?.bank_name || '',
                bank_address: this.account?.bank_address || '',
                beneficiary_name: this.account?.beneficiary_name || '',
                account_number: this.account?.account_number || '',
                routing_number: this.account?.routing_number || '',
                swift_code: this.account?.swift_code || '',
                ifsc_code: this.account?.ifsc_code || '',
                sort_code: this.account?.sort_code || '',
                pan_number: this.account?.pan_number || '',
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
                axios.post(this.route("company.account.store"), { ...this.form, id: this.form.id })
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
    <Modal :show="show" title="Company Account" @onhide="$emit('hidemodal', false)">
        <JetValidationErrors />
        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!-- {{ this.account }}
            {{ this.company.data.id }} -->
            <!--begin::Modal body-->
            <!-- <input type="text" v-model="addressId"> -->
            <div class="me-n7 pe-7 mh-lg-400px" style="overflow-y: auto;">
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="bank_name" value="Bank Name" />
                    <jet-input id="bank_name" type="text" v-model="v$.form.bank_name.$model" :class="v$.form.bank_name.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="Bank Name" />
                    <div v-for="(error, index) of v$.form.bank_name.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="bank_address" value="Bank Address" />
                    <jet-input id="bank_address" type="text" v-model="v$.form.bank_address.$model" :class="v$.form.bank_address.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="Bank Address" />
                    <div v-for="(error, index) of v$.form.bank_address.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="beneficiary_name" value="Beneficiary Name" />
                    <jet-input id="beneficiary_name" type="text" v-model="v$.form.beneficiary_name.$model" :class="v$.form.beneficiary_name.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="Beneficiary Name" />
                    <div v-for="(error, index) of v$.form.beneficiary_name.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="account_number" value="Account Number" />
                    <jet-input id="account_number" type="text" v-model="v$.form.account_number.$model" :class="v$.form.account_number.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="Account Number" />
                    <div v-for="(error, index) of v$.form.account_number.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="routing_number" value="Routing Number" />
                    <jet-input id="routing_number" type="text" v-model="v$.form.routing_number.$model" :class="v$.form.routing_number.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="Routing Number" />
                    <div v-for="(error, index) of v$.form.routing_number.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="swift_code" value="Swift Code" />
                    <jet-input id="swift_code" type="text" v-model="v$.form.swift_code.$model" :class="v$.form.swift_code.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="Swift Code" />
                    <div v-for="(error, index) of v$.form.swift_code.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="ifsc_code" value="IFSC Code" />
                    <jet-input id="ifsc_code" type="text" v-model="v$.form.ifsc_code.$model" :class="v$.form.ifsc_code.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="IFSC Code" />
                    <div v-for="(error, index) of v$.form.ifsc_code.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="sort_code" value="SORT Code" />
                    <jet-input id="sort_code" type="text" v-model="v$.form.sort_code.$model" :class="v$.form.sort_code.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="SORT Code" />
                    <div v-for="(error, index) of v$.form.sort_code.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="pan_number" value="PAN Number" />
                    <jet-input id="pan_number" type="text" v-model="v$.form.pan_number.$model" :class="v$.form.pan_number.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                        " placeholder="PAN Number" />
                    <div v-for="(error, index) of v$.form.pan_number.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>


            </div>
            <div class="d-flex flex-end mt-5">
                <button type="reset" @click="$emit('hidemodal', false)" class="btn btn-light me-3">Discard</button>
                <button type="submit" class="btn btn-primary" :data-kt-indicator="requesting ? 'on' : 'off'">
                    <span class="indicator-label">Update</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </form>
    </Modal>
</template>
