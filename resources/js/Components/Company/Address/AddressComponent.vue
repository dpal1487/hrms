<script>
import { defineComponent } from 'vue';
import EditAddress from './Model/EditAddress.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import 'vue3-toastify/dist/index.css';
import Loading from "vue-loading-overlay";
import axios from "axios";
export default defineComponent({
    props: ['countries', 'company'],
    data() {
        return {
            isEdit: false,
            isLoading: false,
            addressId: null,
        }
    },

    components: {
        EditAddress,
        Link
    },
    methods: {
        toggleModal(value, id) {
            this.isEdit = value;
            this.addressId = id;
        },
        confirmDelete(id, index) {
            this.isLoading = true;

            // console.log("this in my test result", company)
            // const last_name = this.companies.data[index].user.last_name;
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
                        .delete("/company/" + id + "/address/delete")
                        .then((response) => {
                            toast.success(response.data.message);
                            if (response.data.success) {

                                this.company.data.company_addresss.splice(index, 1);
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
    <EditAddress :show="isEdit" :addressId="addressId" @hidemodal="toggleModal" :countries="countries" :company="company" />

    <div class="col-xl-6" v-for="(company, index) in company.data.company_addresss" :key="index">
        <!--begin::Address-->
        <!-- {{ company }} -->
        <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
            <div class="d-flex flex-column py-2">
                <!-- {{ company }} -->
                <div class="d-flex align-items-center fs-5 fw-bold mb-5">Address {{ index + 1 }}
                    <!-- {{ company.is_primary }} -->
                    <span class="badge badge-light-success fs-7 ms-2" v-if="company?.is_primary == 1">Primary</span>
                </div>

                <div class="fs-6 fw-semibold text-gray-600">{{ company?.address_line_1 + " " +
                    company?.address_line_2 }}
                    <br />{{ company?.city + " " + company?.state + " " +
                        company?.pincode }}
                    <br />{{ company?.country?.name }}
                </div>
            </div>
            <!--end::Details-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-2">
                <button class="btn btn-sm btn-light btn-active-light-primary me-3" @click="confirmDelete(
                    company.id, index
                )">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Delete</span>
                    <!--end::Indicator label-->
                </button>
                <!-- <Link class="btn btn-sm btn-light btn-active-light-primary"
                    :href="`/company/edit`">Edit
                </Link> -->
                <button class="btn btn-sm btn-light btn-active-light-primary"
                    @click="toggleModal(true, company.id)">Edit</button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Address-->
    </div>
</template>
