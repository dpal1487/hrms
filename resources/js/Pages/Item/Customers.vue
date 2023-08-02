<script>

import { defineComponent } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';

import Rating from "../CustomerReviews/Rating.vue";
import axios from 'axios';
export default defineComponent({
    props: ['customerreview'],

    data() {
        return {
            title: 'Customers Reviews',
        }
    },

    components: {
        Rating,
        AppLayout,
        Head,
        Link
    },
    methods: {
        download(id) {
            axios.get(this.route("customer.document", id))
                .then((res) => console.log(res.data))
                .catch(err => console.log(err))
            // .then((response) => {
            //     if (response.data.success == true) {
            //         Inertia.get(
            //             "/items",
            //         );
            //     }
            //     else {
            //         toast.error(response.data.message)
            //     }
            // });

        },
    }

});

</script>

<template>
    <Head :title="title" />
    <AppLayout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/items" class="text-muted text-hover-primary">Items</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Customers Reviews</span>
            </li>
        </template>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10 position-relative;">
            <div class="col-sm-12 col-md-5">
                <div class="row col-md-12">
                    <div class="col-md-3">

                        <div class="" v-if="customerreview?.data?.image?.small_path">
                            <img alt="user image" :src="customerreview?.data?.image?.small_path"
                                class="rounded h-100 w-100">
                        </div>
                        <div class="" v-else>
                            <img alt="user image" src="/assets/media/avatars/300-1.jpg" class="rounded h-100 w-100">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div>
                            <span class="fs-3 fw-bold text-gray-800">{{ customerreview?.data?.item_details?.name }}
                            </span><br>
                            <span class="fs-5 fw-bold text-gray-800">{{ customerreview?.data?.category?.name }} </span>
                        </div>
                        <div class="fs-5 fw-bold text-gray-800">
                            <span>Total Cusmtomer</span>
                            <span class="badge badge-light-info fs-6 fw-bold"
                                v-if="customerreview?.data?.total_customers?.count == ''">
                                0 Reviews
                            </span>
                            <span class="badge badge-light-info fs-6 fw-bold" v-else>
                                {{ customerreview?.data?.total_customers?.count }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 overflow-auto">
                <div class="card mb-3 rounded shadow-sm" v-for=" customer in customerreview?.data?.item_customer">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-stretch justify-content-between">
                            <div class="d-flex align-items-stretch">
                                <div class="me-4" style="height: 4rem;">
                                    <img alt="user image" src="/assets/media/avatars/300-1.jpg" class="rounded h-100" />
                                </div>
                                <div class="">
                                    <h4 class="text-gray-850 fs-1">
                                        <span v-if="customer == ''">
                                            John Doe
                                        </span>
                                        <span v-else class="text-capitalize">
                                            {{ customer?.name }}
                                        </span>
                                        <span class="svg-icon round m-5">
                                            <span v-if="customer?.rental_status == 1"
                                                class="badge badge-light-success fs-6 fw-bold">
                                                Active</span>
                                            <span v-else="customer?.status?.id == 0"
                                                class="badge badge-light-danger fs-6 fw-bold">
                                                Inactive</span>
                                        </span>

                                    </h4>
                                    <div>
                                        <h6 class="text-gray-800 fs-4">
                                            <i class="bi bi-person-lines-fill fs-3"></i> User Information
                                        </h6>
                                        <div class="d-flex align-items-center text-gray-800 fs-5 gap-2">
                                            <i class="bi bi-envelope-fill"></i>{{ customer?.email_address ?
                                                customer?.email_address : "No email found" }}
                                            <i class="bi bi-telephone"></i>
                                            {{ customer?.mobile ? customer?.mobile : 'Mobile Not Found' }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mt-5">
                                        <div class="me-20 mb-5">
                                            <h6 class=" fs-4 text-gray-800">
                                                <i class="bi bi-credit-card-fill fs-3 me-2"></i>Security Price
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-currency-rupee fs-4"></i> {{ customer?.security_pay }}
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="text-gray-800 fs-4 ">
                                                <i class="bi bi-files fs-3 me-2"></i>Documents
                                            </h6>
                                            <button @click="download(customer?.document?.id)" class="btn btn-non btn-sm my-0"><i
                                                    class="bi bi-file-earmark-check-fill fs-4"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-fit">
                                <div class="w-fit fs-6 fw-bold text-gray-800">
                                    Since {{ customer?.rental_date }}
                                </div>
                                <div class="w-fit fs-6 fw-bold text-gray-800">
                                    {{ customer?.return_date > 0 ? customer?.return_date : '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>