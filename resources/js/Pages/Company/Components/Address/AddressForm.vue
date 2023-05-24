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
    props: ["countries", "address"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                address_line_1: {
                    required,
                },
                country: {
                    required,
                },
                state: {
                    required,
                },
                city: {
                    required,
                },
                pincode: {
                    required,
                },
                is_primary: {
                },
            },
        };
    },
    data() {
        return {
            is_primary : false,
            form: this.$inertia.form({
                id: this.address?.id,
                address_line_1: this.address?.address_line_1,
                address_line_2: this.address?.address_line_2,
                country: this.address?.country?.id,
                state: this.address?.state,
                city: this.address?.city,
                pincode: this.address?.pincode,
                is_primary: this.address.is_primary
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

        <!--end::Heading-->
        <div class="fv-row mb-3">
            <jet-label for="address-line-1" value="Address Line 1" />
            <jet-input id="address-line-1" type="text" v-model="v$.form.address_line_1.$model" :class="v$.form.address_line_1.$errors.length > 0
                ? 'is-invalid'
                : ''
                " />
            <div v-for="(error, index) of v$.form.address_line_1.$errors" :key="index">
                <input-error :message="error.$message" />
            </div>
        </div>
        <div class="fv-row mb-3">
            <jet-label for="address-line-2" value="Address Line 2" />
            <jet-input id="address-line-2" type="text" v-model="form.address_line_2" />
        </div>
        <div class="row g-9 mb-5">
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="country" value="Country" />
                    <Multiselect id="company-country" :searchable="true" :options="countries" label="name" valueProp="id"
                        class="form-control form-control-solid" placeholder="Select country" :close-on-select="false"
                        :class="v$.form.country.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " v-model="v$.form.country.$model" />
                    <div v-for="(error, index) of v$.form.country
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="state" value="State / Province" />
                    <jet-input id="state" type="text" v-model="v$.form.state.$model" :class="v$.form.state.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.state.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-9 mb-5">
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="city" value="City" />
                    <jet-input id="city" type="text" v-model="v$.form.city.$model" :class="v$.form.city.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.city.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <div class="fv-row mb-3">
                    <jet-label for="post-code" value="Post Code" />
                    <jet-input id="post-code" type="text" v-model="v$.form.pincode.$model" :class="v$.form.pincode.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.pincode.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>

            <div class="fv-row mt-5">
                <div class="d-flex flex-stack">
                    <div class="me-5">
                        <label class="fs-5 fw-semibold">Use as a billing Address?</label>
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
