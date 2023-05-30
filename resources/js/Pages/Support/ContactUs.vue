<script>
import { defineComponent } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { required } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from '@vuelidate/core';
import { toast } from 'vue3-toastify';

export default defineComponent({
    props: ['employees'],
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    validations() {
        return {
            form: {
                name: {
                    required
                },
                email: {
                    required
                },
                mobile: {
                    required
                },
                subject: {
                    required
                },
                message: {
                    required
                },

            }
        }
    },
    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                name: '',
                email: '',
                mobile: '',
                subject: '',
                message: '',
            })
        }
    },

    components: {
        AppLayout,
        Header,
        Link,
        JetInput,
        JetLabel,
        InputError
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route("support.store.contact-us"), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                            
                            return
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                            }
                        },

                    });
            }
        }
    },

})
</script>


<template>
    <AppLayout>
        <Header :employees="employees.data" />
        <template #breadcrumb>

            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support" class="text-muted text-hover-primary">Support</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support/contact-us" class="text-muted text-hover-primary">Contact US</Link>
            </li>
        </template>

        <!--begin::Contact-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-17">
                <!--begin::Row-->
                <div class="row mb-3">
                    <!--begin::Col-->
                    <div class="col-md-6 pe-lg-10">
                        <!--begin::Form-->
                        <form @submit.prevent="submit" class="form mb-15">
                            <h1 class="fw-bold text-dark mb-9">Send Us Email</h1>
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-5 fv-row">
                                <!--begin::Label-->
                                <jet-label for="name" value="Name" />
                                <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Name" />
                                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>


                            <div class="d-flex flex-column mb-5 fv-row">

                                <!--end::Label-->
                                <jet-label for="email" value="Email" />
                                <jet-input id="email" type="text" v-model="v$.form.email.$model" :class="v$.form.email.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Email" />
                                <div v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>


                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-5 fv-row">
                                <!--begin::Label-->
                                <jet-label for="mobile" value="Mobile" />
                                <jet-input id="mobile" type="text" v-model="v$.form.mobile.$model" :class="v$.form.mobile.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Mobile" />
                                <div v-for="(error, index) of v$.form.mobile.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-5 fv-row">
                                <!--begin::Label-->
                                <jet-label for="subject" value="Subject" />
                                <jet-input id="subject" type="text" v-model="v$.form.subject.$model" :class="v$.form.subject.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Subject" />
                                <div v-for="(error, index) of v$.form.subject.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-10 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Message</label>
                                <textarea class="form-control form-control-solid" rows="6" name="message"
                                    v-model="v$.form.message.$model" :class="v$.form.message.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        "></textarea>
                                <div v-for="(error, index) of v$.form.message.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Submit-->
                            <button type="submit" class="btn btn-primary"
                                :data-kt-indicator="form.processing ? 'on' : 'off'">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Send Feedback</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                            <!--end::Submit-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 ps-lg-10">
                        <!--begin::Map-->
                        <div id="kt_contact_map" class="w-100 rounded mb-2 mb-lg-0 mt-2" style="height: 486px"></div>
                        <!--end::Map-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-5 mb-5 mb-lg-15">
                    <!--begin::Col-->
                    <div class="col-sm-6 pe-lg-10">
                        <!--begin::Phone-->
                        <div class="text-center bg-light card-rounded d-flex flex-column justify-content-center p-10 h-100">
                            <!--begin::Icon-->
                            <!--SVG file not found: icons/duotune/finance/fin006.svgPhone.svg-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <h1 class="text-dark fw-bold my-5">Let’s Speak</h1>
                            <!--end::Subtitle-->
                            <!--begin::Number-->
                            <div class="text-gray-700 fw-semibold fs-2">1 (833) 597-7538</div>
                            <!--end::Number-->
                        </div>
                        <!--end::Phone-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 ps-lg-10">
                        <!--begin::Address-->
                        <div class="text-center bg-light card-rounded d-flex flex-column justify-content-center p-10 h-100">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                            <span class="svg-icon svg-icon-3tx svg-icon-primary">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                        fill="currentColor" />
                                    <path
                                        d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <h1 class="text-dark fw-bold my-5">Our Head Office</h1>
                            <!--end::Subtitle-->
                            <!--begin::Description-->
                            <div class="text-gray-700 fs-3 fw-semibold">Churchill-laan 16 II, 1052 CD, Amsterdam</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Address-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Card-->
                <div class="card mb-4 bg-light text-center">
                    <!--begin::Body-->
                    <div class="card-body py-12">
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Contact-->


    </AppLayout>
</template>