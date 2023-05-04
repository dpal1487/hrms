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

    props: ['show', 'company', 'onOnhide', 'email'],
    emits: ['hidemodal'],
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    validations() {
        return {
            form: {
                email_address: {
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
            message: '',
            isEdit: false,
            requesting: false,
            form: {
                email_address: this.email_address || '',
                company_id:  '',
            },
            is_primary: [
                { value: 1, name: "Primary" },
                { value: 0, name: "Secondary" }
            ],
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
                axios.post(this.route("company.email.store"), { ...this.form, id: this.form.id })
                    .then((response) => {
                        if (response.data.success) {
                            toast(response.data.message)
                            this.requesting = false;
                            this.$emit('hidemodal', false);
                            return;
                        } else {
                            toast(response.data.message)
                        }
                    }).finally({

                    });
            }
        },
    }
})
</script>

<template>
    <Modal :show="show" title="Company Email" @onhide="$emit('hidemodal', false)">
        {{ company }}
        <JetValidationErrors />
        <!-- {{ this.email.is_primary }} -->
        <!-- {{ this.email }} -->

        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::Modal body-->
            <!-- <input type="text" v-model="addressId"> -->
            <!-- {{ this.company.data.id }} d<br> -->
            <div class="me-n7 pe-7 mh-lg-400px" style="overflow-y: auto;">
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="contry" value="Status" />
                    <Multiselect :options="is_primary" label="name" valueProp="value"
                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                        v-model="v$.form.is_primary.$model" track-by="name" :searchable="true" :class="v$.form.is_primary.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " />
                    <div v-for="(error, index) of v$.form.is_primary.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>

                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <jet-label for="email_address" value="Email ID" />
                    <jet-input id="email_address" type="text" v-model="v$.form.email_address.$model" :class="v$.form.email_address.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Email ID" />
                    <div v-for="(error, index) of v$.form.email_address.$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>



            </div>
            <div class="d-flex flex-end mt-5">
                <button type="reset" @click="$emit('hidemodal', false)" class="btn btn-light me-3">Discard</button>
                <button type="submit" class="btn btn-primary" :data-kt-indicator="requesting ? 'on' : 'off'">
                    <span class="indicator-label">Save</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </form>
    </Modal>
</template>
