<script>

import { defineComponent } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';

import Rating from "../CustomerReviews/Rating.vue";
export default defineComponent({
    props: ['itemreview'],

    data() {
        return {
            title: 'Customer Review',
            rating: this.itemreview.rating
        }
    },

    components: {
        Rating,
        AppLayout,
        Head,
        Link
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
                <span class="text-muted text-hover-primary">Customer Review</span>
            </li>
        </template>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10 position-relative;">
            <div class="col-sm-12 col-md-5">
                <div class="row col-md-12">
                    <div class="col-md-3">
                        <div class="">
                            <img alt="user image" src="/assets/media/avatars/300-1.jpg" class="rounded h-100 w-100">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="fs-3 fw-bold text-theme-primary">
                            <span>{{ itemreview?.data?.category?.name }} </span><br>
                            <span>Cusmtomer Reviews</span>
                            <span class="badge badge-light-info fs-6 fw-bold" v-if="itemreview?.review == ''">
                                0 Reviews
                            </span>
                            <span class="badge badge-light-info fs-6 fw-bold" v-else>

                                {{ itemreview?.data?.review?.rating }} Reviews
                            </span>
                        </div>
                        <div class="rating">
                            <div class="d-flex">
                                <Rating :rating="itemreview?.data?.review?.rating" />
                            </div>
                            <span class="mx-10 mt-2 fs-5 fw-bold" v-if="itemreview?.data?.review == null">
                                0 Out Of 5
                            </span>
                            <span class="mx-10 mt-2 fs-5 fw-bold" v-else>
                                {{ itemreview?.data?.review?.rating }} Out Of 5
                            </span>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center mt-2">
                                <span class="color:#777777 w-100">5 Stars</span>
                                <div class='ms-4 position-relative bg-secondary rounded-pill'>
                                    <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"></div>
                                </div>
                                <span class='ms-4'>15 Reviews</span>
                            </div>

                            <div class="d-flex align-items-center mt-2">
                                <span class="color:#777777 w-100">4 Stars</span>
                                <div class='ms-4 position-relative bg-secondary rounded-pill'>
                                    <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"></div>
                                </div>
                                <span class='ms-4'>10 Reviews</span>
                            </div>

                            <div class="d-flex align-items-center mt-2">
                                <span class="color:#777777 w-100">3 Stars</span>
                                <div class='ms-4 position-relative bg-secondary rounded-pill'>
                                    <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"></div>
                                </div>
                                <span class='ms-4'>8 Reviews</span>
                            </div>

                            <div class="d-flex align-items-center mt-2">
                                <span class="color:#777777 w-100">2 Stars</span>
                                <div class='ms-4 position-relative bg-secondary rounded-pill'>
                                    <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"></div>
                                </div>
                                <span class='ms-4'>5 Reviews</span>
                            </div>

                            <div class="d-flex align-items-center mt-2">
                                <span class="color:#777777 w-100">1 Stars</span>
                                <div class='ms-4 position-relative bg-secondary rounded-pill'>
                                    <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"></div>
                                </div>
                                <span class='ms-4'>2 Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 overflow-auto">
                <div class="card mb-3 mt-4 rounded shadow-sm" v-for=" review in itemreview?.data?.reviews">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-stretch justify-content-between">
                            <div class="d-flex align-items-stretch">
                                <div class="me-4" style="height: 4rem;">
                                    <img alt="user image" src="/assets/media/avatars/300-1.jpg" class="rounded h-100" />
                                </div>
                                <div class="">
                                    {{ review?.review }}
                                    <!-- <h4>
                                        <span v-if="review == ''">
                                            John Doe
                                        </span>
                                        <span v-else>
                                            {{ review?.user?.first_name + " " + review?.user?.last_name }}
                                        </span>

                                    </h4> -->
                                    <div class="rating">
                                        <div class="d-flex">
                                            <Rating :rating="review?.review?.rating" />

                                            <!-- <x-rating :itemreview="$itemreview" /> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-fit">
                                {{ review?.review?.created_at }}
                            </div>
                        </div>
                        <div class="mt-2">
                            {{ review?.review?.title }}<br>
                            {{ review?.review?.content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>