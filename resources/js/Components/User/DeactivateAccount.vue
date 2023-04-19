<script>
import { defineComponent } from 'vue';
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import axios from "axios";
import { required } from '@vuelidate/validators';


export default defineComponent({
    props: ["employee"],

    validations() {

        return {
            form:
            {
                deactivate:
                {
                    required,
                },
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                id: this.employee?.data?.id,
                deactivate: '',
            })
        }
    },
    components: {

    },
    methods: {
        deactiveActive(id, index) {
            this.isLoading = true;

            if (!this.form.$invalid) {

                // const last_name = this.employees.data[index].user.last_name;
                Swal.fire({
                    title: "Are you sure you want to delete ?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post("/employees/" + id + "/deactivate")
                            .then((response) => {
                                toast.success(response.data.message);
                                if (response.data.success) {
                                    this.employees.data.splice(index, 1);
                                    return;
                                }
                            })

                            .catch((error) => {
                                if (error.response.status == 400) {
                                    toastr.error(error.response.data.message);
                                }
                            });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }

                });
            }
        }
    },
})
</script>
<template>
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Deactivate Account </h3>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_deactivate" class="collapse show">
            <!--begin::Form-->
            <form @submit.prevent="deactiveActive(this.employee.data.id, index)" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Notice-->
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)"
                                    fill="currentColor" />
                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-semibold">
                                <h4 class="text-gray-900 fw-bold">You Are Deactivating Your Account</h4>
                                <div class="fs-6 text-gray-700">For extra security, this requires you to confirm
                                    your email or phone number when you reset yousignr password.
                                    <br />
                                    <a class="fw-bold" href="#">Learn more</a>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                    <!--begin::Form input row-->
                    <div class="form-check form-check-solid fv-row">
                        <input name="deactivate" v-model="form.deactivate" class="form-check-input" type="checkbox" value=""
                            id="deactivate" required />
                        <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">I confirm my account
                            deactivation</label>
                    </div>
                    <!--end::Form input row-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-danger fw-semibold">Deactivate Account</button>
                </div>
                <!--end::Card footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
</template>
