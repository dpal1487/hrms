<style>
.slideimage {
    height: 400px;
}

.carousel__item {
    min-height: 400px;
    width: 100%;
    background-color: #ca5981;
    color: var(--vc-clr-white);
    font-size: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineComponent } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { GoogleMap, Marker } from "vue3-google-map";
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import ReportList from './Component/ReportList.vue';
export default defineComponent({
    props: ['itemdetails'],
    data() {
        return {
            slide: '',
            title: "Item Overview",
            center: null,
           
        }
    },
    components: {
        AppLayout,
        Head,
        Link,
        GoogleMap,
        Marker,
        Carousel,
        Slide,
        Pagination,
        Navigation,
        ReportList
    },

    created() {
        // const center = { lat: this.itemdetails?.data?.location?.country?.longitude, lng: this.itemdetails?.data?.location?.country?.longitude };

        const center = { lat: 28.6490624, lng: 77.0965504 };
        return { center };
    },
    computed: {
        isLocationNull() {
            return this.itemdetails?.data?.location?.address_line_1 == null;
        },
    },
})
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">
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
                <span class="text-muted">Items Overview</span>
            </li>
        </template>

        <div v-if="itemdetails?.data?.images != 0">
            <carousel :autoplay="3000" :wrap-around="true">
                <slide v-for="image in itemdetails?.data?.images" :key="slide">
                    <img :src="image?.small_path" class="d-block w-100 slideimage" alt="...">
                </slide>
                <template #addons>
                    <navigation />
                    <pagination />
                </template>
            </carousel>
        </div>
        <div v-else>
            <carousel>
                <slide v-for="slide in 3" :key="slide">
                    <div class="carousel__item d-block w-100 slideimage"></div>
                </slide>
                <template #addons>
                    <navigation />
                    <pagination />
                </template>
            </carousel>
        </div>
        <div class="row mt-5">
            <div class="col-sm-12 col-md-8">
                <div class="card mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="">
                                <div class="d-flex gap-15">
                                    <div class="d-flex align-items-center ">
                                        <h5 class="card-title fs-2 m-3">Rent Type : </h5>
                                        <h1 class="m-0 fs-4 text-gray-800 text-uppercase"> {{ itemdetails?.data?.time }}
                                        </h1>
                                    </div>
                                    <div class="d-flex align-items-center ">
                                        <h5 class="card-title fs-2 m-3">Rent Prize : </h5>
                                        <h1 class="m-0 fs-4 text-gray-800"> ₹ {{ itemdetails?.data?.rent_price }}</h1>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title fs-1 m-3">Security Prize : </h5>
                                        <h1 class="m-0 fs-4 text-gray-800"> ₹ {{ itemdetails?.data?.security_price }}</h1>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title fs-1 m-3">Category Name : </h5>
                                    <h1 class="m-0 fs-4 text-gray-800">{{ itemdetails?.data?.category?.name }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class=" d-flex">
                                <span class="svg-icon svg-icon-1 me-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                            fill="currentColor" />
                                        <path
                                            d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <div v-if="isLocationNull" class="m-0 fs-4 text-gray-800">
                                    <!-- Handle the case when location is null -->
                                    Location is null
                                </div>
                                <div v-else class="m-0 fs-3 text-gray-800">
                                    <!-- Handle the case when location is not null -->
                                    Location : {{itemdetails?.data?.location?.address_line_1
                                        + " " + itemdetails?.data?.location?.address_line_2
                                        + " " + itemdetails?.data?.location?.city
                                        + " " + itemdetails?.data?.location?.state
                                        + " " + itemdetails?.data?.location?.pincode
                                        + " " + itemdetails?.data?.location?.country?.name }}
                                </div>
                            </div>
                            <div class="">
                                <div class="d-flex">
                                    <h5 class="card-title fs-2 mx-3">From Date : </h5>
                                    <h1 class="fs-4 text-gray-800"> {{ itemdetails?.data?.from_date }}</h1>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-title fs-2 mx-3">To Date : </h5>
                                    <h1 class="fs-4 text-gray-800">{{ itemdetails?.data?.to_date }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-5">
                    <h5 class="card-title fs-1 mt-4 p-3">Attribute</h5>
                    <div class="card-body py-0 bg-slate-400" v-for="(attribute) in  itemdetails?.data?.attributes">
                        <div class="d-flex align-items-center gap-20 gap-y-0 mb-2">
                            <h1 class="fs-4 fw-bold w-25">Name</h1>
                            <h1 class="fs-6 text-uppercase text-gray-800">{{ attribute?.name }}</h1>
                        </div>

                    </div>
                </div>
                <div class="card mb-5">
                    <div class="card-body p-2 m-3">
                        <h5 class="card-title fs-1 mb-4 p-0">Reviews </h5>
                        <h1 class="fs-4 text-gray-800 mx-3"> {{ itemdetails?.data?.rating }} average based on {{
                            itemdetails?.data?.rating_reviews?.count }} reviews.</h1>
                    </div>
                </div>
                <div class="card mb-5">
                    <div class="card-body p-2 m-3">
                        <h5 class="card-title fs-1 mb-4 p-0">Found something unusual ?</h5>
                        <div v-if="Array.isArray(itemdetails?.data?.report) && itemdetails?.data?.report.length > 0">
                            <ReportList :reports="itemdetails?.data?.report" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="">
                                <Link class="user_link d-flex align-items-center gap-4"
                                    :href="`/user/${itemdetails?.data?.user?.id}`">
                                <img alt="user image" src="/assets/media/avatars/300-1.jpg" width="50" height="50">
                                <div
                                    class="user_name fs-3 fw-bold text-theme-primary flex-root d-flex align-items-center justify-content-between">
                                    <span>{{ itemdetails?.data?.user?.first_name + " " +
                                        itemdetails?.data?.user?.last_name }}</span>
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                                    </svg>
                                </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5">
                    <div class="card-body p-2 m-3">
                        <h5 class="card-title fs-1 mb-4 p-0">Posted In</h5>
                        <GoogleMap api-key="YOUR_GOOGLE_MAPS_API_KEY" style="width: 100%; height: 400px" :center="center"
                            :zoom="15">
                            <Marker :options="{ position: center }" />
                        </GoogleMap>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>