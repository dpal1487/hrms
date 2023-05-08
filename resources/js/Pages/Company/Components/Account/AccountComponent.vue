<script>
import { defineComponent } from 'vue';
import FormAccount from './FormAccount.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import 'vue3-toastify/dist/index.css';
import axios from "axios";
export default defineComponent({
    props: ['accounts'],
    emits: ['onhide'],
    data() {
        return {
            isEdit: false,
            isLoading: false,
            account: [],
            showModal: false,

        }
    },

    components: {
        FormAccount,
        Link
    },
    methods: {
        toggleModal(value, account) {
            if (value) {
                this.isEdit = true;
                this.showModal = true;
                this.account = account;
            }
            else {
                this.showModal = false;
            }

        },
        confirmDelete(id, index) {
            this.isLoading = true;

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
                        .delete(this.route("account.delete", ['account', id]))

                        .then((response) => {
                            toast.success(response.data.message);
                            if (response.data.success) {
                                this.accounts.data.splice(index, 1);
                                return;
                            }
                        })

                        .catch((error) => {
                            if (error.response.status == 400) {
                                toast.error(error.response.data.message);
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
        },
    }
})
</script>
<template>
    <FormAccount v-if="showModal" :show="showModal" :isEdit="isEdit" @hidemodal="toggleModal(false)" :account="account" />
    <div class="col-xl-6" v-for="(account, index) in accounts.data" :key="index">
        <!--begin::account-->
        <div class="card card-dashed h-xl-100 flex-row gap-6 p-6">
            <div class="d-flex flex-column flex-root">
                <div class="d-flex align-items-center fs-5 fw-bold mb-5">Account {{ index + 1 }}
                    <span class="badge badge-light-success fs-7 ms-2" v-if="account?.is_primary == 1">Primary</span>
                </div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="fw-bold me-4 text-gray-800">Bank Name : </div>
                        <div class="text-gray-600"> {{ account?.bank_name }}</div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap">
                        <div class="fw-bold me-4 text-gray-800">Bank Address : </div>
                        <div class="text-gray-600"> {{ account?.bank_address }}</div>
                    </div>


                    <div class="d-flex align-items-center flex-wrap">
                        <div class="fw-bold me-4 text-gray-800">Beneficiary Name : </div>
                        <div class="text-gray-600"> {{ account?.beneficiary_name }}</div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="fw-bold me-4 text-gray-800">Account Number : </div>
                        <div class="text-gray-600"> {{ account?.account_number }}</div>
                    </div>


                    <div class="d-flex align-items-center flex-wrap">
                        <div class="fw-bold me-4 text-gray-800">Routing Number : </div>
                        <div class="text-gray-600"> {{ account?.routing_number }}</div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="fw-bold text-gray-800">Swift Code : <span class="text-gray-600"> {{
                                account?.swift_code }}</span></div>

                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-gray-800">IFSC Code : <span class="text-gray-600"> {{
                                account?.ifsc_code }}</span> </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="fw-bold text-gray-800">SORT Code : <span class="text-gray-600"> {{
                                account?.sort_code }}</span></div>

                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-gray-800">PAN Number : <span class="text-gray-600"> {{
                                account?.pan_number }}</span> </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Details-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center justify-content-center w-fit">
                <button class="btn btn-sm btn-light btn-active-light-primary me-3" @click="confirmDelete(
                    account.id, index
                )">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Delete</span>
                    <!--end::Indicator label-->
                </button>
                <!-- <Link class="btn btn-sm btn-light btn-active-light-primary"
                    :href="`/company/edit`">Edit
                </Link> -->
                <button class="btn btn-sm btn-light btn-active-light-primary"
                    @click="toggleModal(true, account)">Edit</button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::account-->
    </div>
</template>
