<script>
import { defineComponent } from 'vue';

import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from '@vuelidate/core';
import { required, email, sameAs } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import axios from 'axios';

export default defineComponent({
    props: ["email"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                email: {
                    required,
                    email: email
                },
                confirm_password: {
                    required,
                    sameAs: sameAs(this.email?.password)
                }
            }
        }
    },
    data() {
        return {
            isEdit: false,
            form: this.$inertia.form({
                id: this.email?.id || '',
                email: this.email?.email || '',
                confirm_password: ''
            }),
        }
    },
    components: {
        JetInput,
        JetLabel,
        JetValidationErrors,
    },
    methods: {
        showEditEmail() {
            this.isEdit = true;
        },
        hideEditEmail() {
            this.isEdit = false;
        },
        submit() {
            this.v$.$touch();
            if (!this.form.$invalid) {
                axios.post(route('employees.email.update', this.form.id), this.form).then((response) => {
                    if (response.data.success) {
                        toast(response.data.message)
                        return;
                    } else {
                        toast(response.data.message)
                    }
                }).finally(() => {
                    this.isEdit = false;
                    this.form.reset()
                });
            }
        },
    }
})
</script>

<template>
    <div v-if="isEdit" class="flex-row-fluid">
        <!--begin::Form-->
        <JetValidationErrors />
        <form @submit.prevent="submit()" class="">
            <div class="row mb-6">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="fv-row mb-0">
                        <!-- <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New
                            Email Address </label>
                        <input type="email" class="form-control form-control-lg form-control-solid"
                            placeholder="Email Address" v-model="v$.form.email.$modal" /> -->

                        <jet-label for="email" value="Enter New
                            Email Address" />
                        <jet-input id="email" type="email" v-model="v$.form.email.$model" :class="v$.form.email.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                            " placeholder="Email Id" />

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="fv-row mb-0">
                        <jet-label for="password" value="Confirm Password" />
                        <jet-input id="password" type="password" v-model="v$.form.confirm_password.$model" :class="v$.form.confirm_password.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                            " placeholder="Confirm Password" />
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary me-2 px-6">Update
                    Email</button>
                <button type="button" @click="hideEditEmail"
                    class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <div v-else class="d-flex flex-wrap align-items-center">
        <div>
            <div class="fs-6 fw-bold mb-1">Email Address</div>
            <div class="fw-semibold text-gray-600">{{ email?.email }}</div>
        </div>
        <!--end::Label-->
        <!--begin::Edit-->

        <!--end::Edit-->
        <!--begin::Action-->
        <div class="ms-auto">
            <button type="button" @click="showEditEmail" class="btn btn-light btn-active-light-primary">Change
                Email</button>
        </div>
        <!--end::Action-->
    </div>
</template>
