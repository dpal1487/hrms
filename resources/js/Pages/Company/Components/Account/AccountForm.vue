<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
export default defineComponent({
    emits: ["submitted"],
    props: ["countries", "account"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                bank_name: {
                    required,
                },
                bank_address: {
                    required
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
                    required
                },
                ifsc_code: {
                    required,
                },
                sort_code: {
                    required,
                },
                pan_number: {
                    required
                },
                is_primary: {

                }
            },
        };
    },
    data() {
        return {
            is_primary: false,

            form: this.$inertia.form({
                id: this.account?.id,
                bank_name: this.account?.bank_name || '',
                bank_address: this.account?.bank_address || '',
                beneficiary_name: this.account?.beneficiary_name || '',
                account_number: this.account?.account_number || '',
                routing_number: this.account?.routing_number || '',
                swift_code: this.account.swift_code || '',
                ifsc_code: this.account.ifsc_code || '',
                sort_code: this.account?.sort_code || '',
                pan_number: this.account?.pan_number || '',
                is_primary: this.account?.is_primary,
            }),
        };
    },
    components: {
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.$emit('submitted', this.form)
            }
        },
    },
});
</script>
<template>
    <JetValidationErrors />
    <form @submit.prevent="submit" class="my-auto pb-5">

        <div class="row g-9 mb-5">
            <!--begin::Col-->

            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="bank-name" value="Bank Name" />
                    <jet-input id="bank-name" type="text" v-model="v$.form.bank_name.$model" :class="v$.form.bank_name.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.bank_name.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">

                <div class="fv-row mb-3">
                    <jet-label for="bank-address" value="Bank Address" />
                    <jet-input id="bank-address" type="text" v-model="v$.form.bank_address.$model" :class="v$.form.bank_address.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.bank_address.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-9 mb-5">
            <!--begin::Col-->

            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="beneficiary-name" value="Beneficiary Name" />
                    <jet-input id="beneficiary-name" type="text" v-model="v$.form.beneficiary_name.$model" :class="v$.form.beneficiary_name.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.beneficiary_name.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="account_number" value="Account Number" />
                    <jet-input id="account_number" type="text" v-model="v$.form.account_number.$model" :class="v$.form.account_number.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.account_number.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-9 mb-5">
            <!--begin::Col-->

            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="routing-number" value="Routing Number" />
                    <jet-input id="routing-number" type="text" v-model="v$.form.routing_number.$model" :class="v$.form.routing_number.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.routing_number.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="swift-code" value="Swift Code" />
                    <jet-input id="swift-code" type="text" v-model="v$.form.swift_code.$model" :class="v$.form.swift_code.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.swift_code.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-9 mb-5">
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="ifsc-code" value="IFSC Code" />
                    <jet-input id="ifsc-code" type="text" v-model="v$.form.ifsc_code.$model" :class="v$.form.ifsc_code.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.ifsc_code.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="sort-code" value="Sort Code" />
                    <jet-input id="sort-code" type="text" v-model="v$.form.sort_code.$model" :class="v$.form.sort_code.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.sort_code.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="pan-number" value="Pan Number" />
                    <jet-input id="pan-number" type="text" v-model="v$.form.pan_number.$model" :class="v$.form.pan_number.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.pan_number.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>

            <div class="fv-row mt-5">
                <div class="d-flex flex-stack">
                    <div class="me-5">
                        <label class="fs-5 fw-semibold">Use as a billing Account?</label>
                    </div>
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" v-model="v$.form.is_primary.$model" type="checkbox" />
                        <span class="form-check-label fw-semibold text-muted">
                            Yes
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </form>
</template>
