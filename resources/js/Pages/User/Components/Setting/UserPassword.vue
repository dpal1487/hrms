<script>
import { defineComponent } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { toast } from 'vue3-toastify';

export default defineComponent({

    props: ["password"],

    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                password: {
                    required,
                }
            }
        }
    },
    data() {
        return {
            isEdit: false,
            form: this.$inertia.form({
                id: this.password?.id || '',
                old_password: '',
                new_password: '',
                confirm_password: '',
            })
        }
    },
    components: {
        JetInput,
        JetLabel,
    },
    methods: {
        showChangePassword() {
            this.isEdit = true;
        },
        hideChangePassword() {
            this.isEdit = false;
        },
        submit() {
            if (!this.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(route('account.change-password'), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                            this.isEdit = false;
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                                this.isEdit = false;
                            }
                        },
                    });


            }
        },
    }
})

</script>
<template>
    <div v-if="isEdit" class="flex-row-fluid mb-10">
        <!--begin::Form-->
        <form @submit.prevent="submit()" class="">

            <div class="row mb-1">
                <div class="col-lg-4">
                    <div class="fv-row mb-0">
                        <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current
                            Password</label>
                        <input type="password" class="form-control form-control-lg form-control-solid"
                            v-model="form.old_password" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="fv-row mb-0">
                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New
                            Password</label>
                        <input type="password" class="form-control form-control-lg form-control-solid"
                            v-model="form.new_password" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="fv-row mb-0">
                        <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm
                            New Password</label>
                        <input type="password" class="form-control form-control-lg form-control-solid"
                            v-model="form.confirm_password" />
                    </div>
                </div>
            </div>
            <div class="form-text mb-5">Password must be at least 8 character and contain symbols
            </div>
            <div class="d-flex gap-5">
                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Update Password
                </button>
                <button type="button" @click="hideChangePassword" class="btn btn-outline-secondary">Discard </button>

                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </div>
        </form>
        <!--end::Form-->
    </div>

    <div v-else class="d-flex flex-wrap align-items-center mb-10">
        <!--begin::Label-->
        <div>
            <div class="fs-6 fw-bold mb-1">Password</div>
            <div class="fw-semibold text-gray-600">************</div>
        </div>
        <!--end::Label-->
        <!--begin::Edit-->

        <!--end::Edit-->
        <!--begin::Action-->
        <div class="ms-auto">
            <button class="btn btn-light btn-active-light-primary" @click="showChangePassword">Reset Password</button>
        </div>
        <!--end::Action-->
    </div>
</template>
