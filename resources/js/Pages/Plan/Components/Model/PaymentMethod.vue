<script>
import { defineComponent } from 'vue';
import Modal from '@/Components/Modal.vue';
import { toast } from 'vue3-toastify';
import axios from 'axios';

import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default defineComponent({
    props: ['users', 'plan', 'show'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required
                }
            }

        }
    },
    data() {
        return {
            processing: false,

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
                id: this.plan?.id,
                name: '',
                stripe_price: this.plan?.price || '',
            }),

        }
    },
    components: {
        Modal,
        JetInput,
        JetLabel,
        InputError,
    },

    methods:
    {

        includeStripe(URL, callback) {
            var documentTag = document, tag = 'script',
                object = documentTag.createElement(tag),
                scriptTag = documentTag.getElementsByTagName(tag)[0];
            object.src = '//' + URL;
            if (callback) { object.addEventListener('load', function (e) { callback(null, e); }, false); }
            scriptTag.parentNode.insertBefore(object, scriptTag);
        },


       

        /*
            Loads the payment intent key for the user to pay.
        */
        loadIntent() {
            axios.get('/plan/setup-intent')
                .then(function (response) {
                    this.intentToken = response.data;
                }.bind(this));
        },


        submitPaymentMethod() {
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
        },


        savePaymentMethod(method) {
            axios.post('/plan/payments', {
                payment_method: method
            }).then(function () {
                this.loadPaymentMethods();
            }.bind(this));
        },

        /*
            Loads all of the payment methods for the
            user.
        */
        loadPaymentMethods() {
            this.paymentMethodsLoadStatus = 1;

            axios.get('/plan/payment-methods')
                .then(function (response) {
                    this.paymentMethods = response.data;

                    this.paymentMethodsLoadStatus = 2;
                    // this.setDefaultPaymentMethod();
                }.bind(this));
        },

        removePaymentMethod(paymentID) {
            axios.post('/plan/remove-payment', {
                id: paymentID
            }).then(function (response) {
                this.loadPaymentMethods();
            }.bind(this));
        },

        updateSubscription() {
            axios.put('/plan/subscription', {
                plan: this.selectedPlan,
                payment: this.paymentMethodSelected
            }).then(function (response) {
                console.log(response);
            }.bind(this));
        },
    }
});
</script>
<template>
    <Modal :show="show" @onhide="$emit('hidemodal')" title="Add New Card">
        <div class="d-flex flex-column mb-7 fv-row">
            <h3>Manage Your Subscription</h3>

            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                <span class="required">Name On Card</span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                    title="Specify a card holder's name"></i>
            </label>
            <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                ? 'is-invalid'
                : ''
                " placeholder="Name" />
            <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                <input-error :message="error.$message" />
            </div>
        </div>


        <div class="d-flex flex-column mb-7 fv-row">

            <label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>

            <div id="card-element">

            </div>

            <button class="btn btn-primary mt-3" id="add-card-button" v-on:click="submitPaymentMethod()">
                Save Payment Method
            </button>


        </div>
    </Modal>
</template>