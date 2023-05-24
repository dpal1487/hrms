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
    props: ["email"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                email_address: {
                    required,
                },
                is_primary: {
                },
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                id: this.email?.id,
                email_address: this.email?.email_address || '',
                is_primary: this.email?.is_primary || '',
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
            <jet-label for="email-address" value="Email Id" />
            <jet-input id="email-address" type="text" v-model="v$.form.email_address.$model" :class="v$.form.email_address.$errors.length > 0
                ? 'is-invalid'
                : ''
                " />
            <div v-for="(error, index) of v$.form.email_address.$errors" :key="index">
                <input-error :message="error.$message" />
            </div>
        </div>

        <!--begin::Col-->
        <div class="fv-row mt-5">
            <div class="d-flex flex-stack">
                <div class="me-5">
                    <label class="fs-5 fw-semibold">Use as a billing Email?</label>
                </div>
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" v-model="v$.form.is_primary.$model" type="checkbox" />
                    <span class="form-check-label fw-semibold text-muted">
                        Yes
                    </span>
                </label>
            </div>
        </div>


        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </form>
</template>
