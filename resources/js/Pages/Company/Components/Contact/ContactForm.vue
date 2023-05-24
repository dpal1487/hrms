<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required,email } from "@vuelidate/validators";
export default defineComponent({
    emits: ["submitted"],
    props: ["countries", "contact"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                email: {
                    required,
                    email
                },
                phone: {
                    required,
                },
                country: {
                    required,
                },
                is_primary: {
                    required,
                },
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                id: this.contact?.id,
                name: this.contact?.name,
                email: this.contact?.email,
                country: this.contact?.country?.id,
                phone: this.contact?.phone,
                is_primary: this.contact.is_primary
            }),
        };
    },
    components: {
        Link,
        Head,
        Multiselect,
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
        <!--begin::Wrapper-->
        <div class="row g-5">
            <div class="fv-row col-md-6">
                <jet-label for="contact-name" value="Name" />
                <jet-input id="contact-name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter contact person name" />
                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <jet-label for="contact-email" value="Email" />
                <jet-input id="contact-email" type="text" v-model="v$.form.email.$model" :class="v$.form.email.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter email address" />
                <div v-for="(error, index) of v$.form.email.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <jet-label for="contact-phone" value="Mobile" />
                <jet-input id="contact-phone" type="text" v-model="v$.form.phone.$model" :class="v$.form.phone.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter mobile number" />
                <div v-for="(error, index) of v$.form.phone.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="col-md-6 fv-row">
                <jet-label for="contact-country" value="Country" />
                <Multiselect :options="countries" label="label" valueProp="id" class="form-control form-control-solid"
                    placeholder="Select country" :searchable="true" v-model="v$.form.country.$model" :class="v$.form.country.$errors.length >
                        0
                        ? 'is-invalid'
                        : ''
                        " />
                <div v-for="(error, index) of v$.form
                    .country.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>

            <div class="fv-row col-md-12 mb-5">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack">
                    <!--begin::Label-->
                    <div class="me-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold">Use as a primary contact?</label>
                        <!--end::Label-->
                    </div>
                    <!--end::Label-->
                    <!--begin::Switch-->
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input" v-model="v$.form.is_primary.$model"
                            :checked="v$.form.is_primary.$model == 1 ? 'checked' : ''" type="checkbox" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label fw-semibold text-muted">
                            Yes
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Switch-->
                </div>
                <!--begin::Wrapper-->
            </div>
        </div>

        <!--end::Wrapper-->
        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </form>
</template>
