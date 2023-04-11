<template>
    <Head title="Log in" />

    <jet-authentication-card>
        <form
            @submit.prevent="submit"
            class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework"
        >
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
                <!--end::Title-->

                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">
                    Your Social Campaigns
                </div>
                <!--end::Subtitle--->
            </div>
            <!--begin::Heading-->
            <!--begin::Input group--->
            <JetValidationErrors />
            <div class="row mb-8">
                <!--begin::Col-->
                <div class="col-lg-6 fv-row fv-plugins-icon-container">
                    <jet-input
                        id="first_name"
                        type="text"
                        placeholder="First name"
                        v-model="v$.form.first_name.$model"
                        :class="
                            v$.form.first_name.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                        "
                    />
                    <div
                        v-for="(error, index) of v$.form.first_name.$errors"
                        :key="index"
                    >
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-lg-6 fv-row fv-plugins-icon-container">
                    <jet-input
                        id="last_name"
                        type="text"
                        placeholder="Last name"
                        v-model="v$.form.last_name.$model"
                        autofocus
                        :class="
                            v$.form.last_name.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                        "
                    />
                    <div
                        v-for="(error, index) of v$.form.last_name.$errors"
                        :key="index"
                    >
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <div class="fv-row mb-8 fv-plugins-icon-container">
                <!--begin::Email-->
                <jet-input
                    id="email"
                    type="email"
                    placeholder="Email address"
                    v-model="v$.form.email.$model"
                    autofocus
                    :class="
                        v$.form.email.$errors.length > 0 ? 'is-invalid' : ''
                    "
                />
                <div
                    v-for="(error, index) of v$.form.email.$errors"
                    :key="index"
                >
                    <input-error :message="error.$message" />
                </div>
            </div>
            <!--end::Input group--->
            <div class="fv-row mb-8 fv-plugins-icon-container">
                <!--begin::Wrapper-->
                <div class="mb-1">
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <jet-input
                            id="password"
                            type="password"
                            placeholder="Password"
                            v-model="v$.form.password.$model"
                            :class="
                                v$.form.password.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                            "
                        />
                        <span
                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0"
                        >
                            <i class="fas fa-eye-slash"></i>
                            <i class="fas fa-eye fs-2 d-none"></i>
                        </span>
                    </div>
                    <!--end::Input wrapper-->
                </div>
                <div
                    v-for="(error, index) of v$.form.password.$errors"
                    :key="index"
                >
                    <input-error :message="error.$message" />
                </div>
                <!--end::Wrapper-->
                <!--begin::Hint-->
                <div class="text-muted">
                    Use 8 or more characters with a mix of letters, numbers
                    &amp; symbols.
                </div>
                <!--end::Input group--->
            </div>
            <div class="fv-row mb-8 fv-plugins-icon-container">
                <!--begin::Repeat Password-->
                <jet-input
                    id="confirm-password"
                    placeholder="Confirm password"
                    type="password"
                    v-model="v$.form.password_confirmation.$model"
                    :class="
                        v$.form.password_confirmation.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                    "
                />
                <!--end::Repeat Password-->
                <div
                    v-for="(error, index) of v$.form.password_confirmation
                        .$errors"
                    :key="index"
                >
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row mb-8 fv-plugins-icon-container">
                <label class="form-check form-check-inline">
                    <jet-checkbox
                        name="terms"
                        id="terms"
                        v-model:checked="form.terms"
                    />
                    <span
                        class="form-check-label fw-semibold text-gray-700 fs-base ms-1"
                    >
                        I Accept the
                        <Link
                            href="/terms-and-condition"
                            class="ms-1 link-primary"
                            >Terms</Link
                        >
                    </span>
                </label>
                <div
                    class="fv-plugins-message-container invalid-feedback"
                ></div>
            </div>
            <!--end::Wrapper-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <primary-button
                    :disabled="v$.form.$invalid"
                    :class="{ 'text-white-50': form.processing }"
                >
                    <div
                        v-show="form.processing"
                        class="spinner-border spinner-border-sm"
                        role="status"
                    >
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Sign Up
                </primary-button>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            <div class="text-gray-500 text-center fw-semibold fs-6">
                Already have an Account?
                <Link href="/login" class="link-primary fw-semibold">
                    Sign in
                </Link>
            </div>
            <!--end::Sign up-->
        </form>
    </jet-authentication-card>
</template>

<script>
import { defineComponent } from "vue";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import { required, email, minLength } from "@vuelidate/validators";

export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        PrimaryButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        InputError,
        Link,
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
                email: {
                    required,
                    email,
                },
                password: {
                    required,
                    min: minLength(6),
                },
                password_confirmation: {
                    required,
                    min: minLength(6),
                },
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                first_name: "",
                last_name: "",
                email: "",
                password: "",
                password_confirmation: "",
                terms: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                }))
                .post(this.route("register"));
        },
    },
});
</script>
