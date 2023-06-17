<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";

import JetInput from "@/Jetstream/Input.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import axios from "axios";
export default defineComponent({
    props: ["plan", "message"],

    setup() {
        return { v$: useVuelidate() };
    },

    validations() {
        return {
            form: {
                name: {
                    required,
                }
            },
        };
    },

    data() {
        return {

            processing: '',

            stripeAPIToken: 'pk_test_51LprceSJxuPNyrb7PFICoE9gKbZLWNuLIVk8jx9mShL4w5hGzJOQCgwK4cnFBo9hLWcnVC0AQn7viBywJhbPEt7h00NKSZiSIG',

            stripe: '',
            elements: '',
            card: '',

            intentToken: '',

            name: '',
            addPaymentStatus: 0,
            addPaymentStatusError: '',

            paymentMethods: [],
            paymentMethodsLoadStatus: 0,
            paymentMethodSelected: {},

            selectedPlan: '',

            form: this.$inertia.form({
                id: this.plan?.data?.id,
                name: '',
                stripe_price: this.plan.data.price || '',
            }),
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        InputError,
        JetInput,
        Pagination,
        Multiselect,
        Loading,
    },
    mounted() {
        this.includeStripe('js.stripe.com/v3/', function () {
            this.configureStripe();
        }.bind(this));

        this.loadIntent();

        this.loadPaymentMethods();
    },
    methods: {

        includeStripe(URL, callback) {
            var documentTag = document, tag = 'script',
                object = documentTag.createElement(tag),
                scriptTag = documentTag.getElementsByTagName(tag)[0];
            object.src = '//' + URL;
            if (callback) { object.addEventListener('load', function (e) { callback(null, e); }, false); }
            scriptTag.parentNode.insertBefore(object, scriptTag);
        },

        configureStripe() {
            this.stripe = Stripe(this.stripeAPIToken);

            this.elements = this.stripe.elements();
            this.card = this.elements.create('card');

            this.card.mount('#card-element');
        },

        loadIntent() {
            axios.get('plan/setup-intent')
                .then(function (response) {
                    this.intentToken = response.data;
                }.bind(this));
        },

        submit() {

            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true

                this.addPaymentStatus = 1;

                this.stripe.confirmCardSetup(
                    this.intentToken.client_secret, {
                    payment_method: {
                        card: this.card,
                        billing_details: {
                            name: this.name
                        }
                    }
                }
                ).then(function (result) {
                    if (result.error) {
                        this.addPaymentStatus = 3;
                        this.addPaymentStatusError = result.error.message;
                    } else {
                        this.savePaymentMethod(result.setupIntent.payment_method);
                        this.addPaymentStatus = 2;
                        this.card.clear();
                        this.name = '';
                    }
                }.bind(this));
            }
        },

        savePaymentMethod(method) {
            axios.post('plan/payments', {
                payment_method: method
            }).then(function () {
                this.loadPaymentMethods();
            }.bind(this));
        },
        loadPaymentMethods() {
            this.paymentMethodsLoadStatus = 1;

            axios.get('plan/payment-methods')
                .then(function (response) {
                    this.paymentMethods = response.data;

                    this.paymentMethodsLoadStatus = 2;
                }.bind(this));
        },

        updateSubscription(id) {
            axios.post('plan/subscription', { id: id })
                .then(function (response) {
                    console.log(response);
                }.bind(this));
        },
    },
});
</script>
<template>
    <app-layout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/plan" class="text-muted text-hover-primary">Plan</Link>
            </li>
        </template>

        <Head title="Plan" />
        <!--begin::Content-->

        <div class="row justify-content-center border-spacing-1">
            <div class="col-md-10 m-0">

                <div class="card">
                    <h3>Manage Your Subscription</h3>

                    <div class="card-header">

                        <h4 class="text-gray-700 mt-5">You will be charged ${{ plan?.data?.price }} for {{ plan?.data?.name
                        }} Plan
                        </h4>
                    </div>

                    <div class="card-body">
                        <!-- <button type="submit" class="btn btn-primary" id="card-button" v-on:click="submitPaymentMethod()"
                            data-secret="{{ $intent->client_secret }}">Purchase</button> -->

                        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10">
                                    <div class="form-group">
                                        <label class="d-flex align-items-center fs-6 fw-bold form-label">
                                            <span class="required">Name On Card</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify a card holder's name"></i>
                                        </label>
                                        <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Name on the card" />
                                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-10">
                                <div class="col-xl-8 col-lg-10">
                                    <div class="form-group">
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold form-label mb-2">Card Details</label>
                                        </div>
                                        <div id="card-element"></div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <hr>
                                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                        :data-kt-indicator="processing ? 'on' : 'off'">
                                        <span class="indicator-label">
                                            <span>Purchase</span>
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>
