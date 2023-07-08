<template>
    <Head title="Log in" />
    <jet-authentication-card>
        <form @submit.prevent="submit" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework">
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                <!--end::Title-->
                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">
                    Your Social Campaigns
                </div>
                <!--end::Subtitle--->
            </div>
            <div class="row g-3 mb-9">
                <!--begin::Col-->
                <div class="col-md-6">
                    <!--begin::Google link--->
                    <a href="/login/google"
                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                        <img alt="Logo" src="/assets/media/svg/social-logos/google.svg" class="h-15px me-3">
                        Sign in with Google
                    </a>
                    <!--end::Google link--->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-md-6">
                    <!--begin::Google link--->
                    <a href="/login/facebook"
                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                        <img alt="Logo" src="/assets/media/svg/social-logos/facebook.svg"
                            class="theme-light-show h-15px me-3">
                        <img alt="Logo" src="/assets/media/svg/social-logos/facebook.svg"
                            class="theme-dark-show h-15px me-3">
                        Sign in with Facebook
                    </a>
                    <!--end::Google link--->
                </div>
                <!--end::Col-->
            </div>
            <!--begin::Heading-->
            <!--begin::Input group--->
            <JetValidationErrors />

            <div class="fv-row mb-8 fv-plugins-icon-container">
                <!--begin::Email-->
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" v-model="v$.form.email.$model" autofocus :class="v$.form.email.$errors.length > 0 ? 'is-invalid' : ''
                    " />
                <div v-for="(error, index) of v$.form.email.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <!--end::Input group--->
            <div class="fv-row mb-3 fv-plugins-icon-container">
                <!--begin::Password-->
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" v-model="v$.form.password.$model" :class="v$.form.password.$errors.length > 0 ? 'is-invalid' : ''
                    " />
                <div v-for="(error, index) of v$.form.password.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <!--end::Input group--->

            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <primary-button :disabled="form.processing" :class="{ 'text-white-50': form.processing }">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Log in
                </primary-button>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            <div class="text-gray-500 text-center fw-semibold fs-6">
                Not a Member yet?
                <Link href="/register" class="link-primary"> Sign up </Link>
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
import { toast } from "vue3-toastify";
import Swal from "sweetalert2";

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
                email: {
                    required,
                    email,
                },
                password: {
                    required,
                    min: minLength(6),
                },
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false,
            }),
        };
    },

    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                        remember: this.form.remember ? "on" : "",
                    }))
                    .post(this.route("login"), {

                        onSuccess: (data) => {
                            Swal.fire({
                                title: "Login success",
                                text: "",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            })
                            // toast.success(this.$page.props.jetstream.flash.message);
                        },
                        onError: (data) => {
                            console.log(data)
                            Swal.fire({
                                title: "Login Failed",
                                text: "Please try with a valid credentials",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 1500
                            })
                            // if (data.message) {
                            //     toast.error(data.message)
                            // }
                        },
                        onFinish: () => this.form.reset("password"),
                    });
            }
        },
        authProvider(provider) {
            let self = this;
            this.$auth
                .authenticate(provider)
                .then((response) => {
                    self.socialLogin(provider, response);
                })
                .catch((err) => {
                    console.log({ err: err });
                });
        },
        socialLogin(provider, response) {
            this.$http
                .post("/social/" + provider, response)
                .then((response) => {
                    return response.data.token;
                })
                .catch((err) => {
                    console.log({ err: err });
                });
        },
    },
});
</script>
