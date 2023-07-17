<style>
.slideimage {
    height: 400px;
}
</style>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineComponent } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";


export default defineComponent({

    props: ['itemdetails'],

    data() {
        return {
            title: "Item Review"
        }
    },
    components: {
        AppLayout,
        Head,
        Link
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
        </template>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Details-->
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>

                    <div class="carousel-inner position-relative" v-if="itemdetails?.data?.image"
                        v-for="image in itemdetails?.data?.image">
                        <div class="carousel-item active">
                            <div class="bg-dark w-100">

                                <div class="w-75 mx-auto">
                                    <img src="/assets/media/avatars/300-1.jpg" class="d-block w-100 slideimage" alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="bg-dark w-100">
                                <div class="w-75 mx-auto">
                                    <img src="/assets/media/avatars/300-2.jpg" class="d-block w-100 slideimage" alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="bg-dark w-100">
                                <div class="w-75 mx-auto">
                                    <img src="/assets/media/avatars/300-3.jpg" class="d-block w-100 slideimage" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="carousel-inner position-relative">
                        <div class="carousel-item active">
                            <div class="bg-dark w-100">
                                <div class="w-75 mx-auto">
                                    <img src="/assets/media/avatars/300-4.jpg" class="d-block w-100 slideimage" alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="bg-dark w-100">
                                <div class="w-75 mx-aut">
                                    <img src="/assets/media/avatars/300-5.jpg" class="d-block w-100 slideimage" alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="bg-dark w-100">
                                <div class="w-75 mx-auto ">
                                    <img src="/assets/media/avatars/300-6.jpg" class="d-block w-100 slideimage" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!--end::Details-->
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="card mb-3">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">

                                        <h5 class="card-title fs-1 m-0">₹ {{ itemdetails?.data?.rent_price }} </h5>
                                        <p class="card-text fs-4">{{ itemdetails?.data?.category?.name }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-evenly gap-2">
                                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                            aria-hidden="true" height="1.5em" width="1.5em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <span class="fs-2">0</span>
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                            viewBox="0 0 1024 1024" height="1.5em" width="1.5em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M752 664c-28.5 0-54.8 10-75.4 26.7L469.4 540.8a160.68 160.68 0 0 0 0-57.6l207.2-149.9C697.2 350 723.5 360 752 360c66.2 0 120-53.8 120-120s-53.8-120-120-120-120 53.8-120 120c0 11.6 1.6 22.7 4.7 33.3L439.9 415.8C410.7 377.1 364.3 352 312 352c-88.4 0-160 71.6-160 160s71.6 160 160 160c52.3 0 98.7-25.1 127.9-63.8l196.8 142.5c-3.1 10.6-4.7 21.8-4.7 33.3 0 66.2 53.8 120 120 120s120-53.8 120-120-53.8-120-120-120zm0-476c28.7 0 52 23.3 52 52s-23.3 52-52 52-52-23.3-52-52 23.3-52 52-52zM312 600c-48.5 0-88-39.5-88-88s39.5-88 88-88 88 39.5 88 88-39.5 88-88 88zm440 236c-28.7 0-52-23.3-52-52s23.3-52 52-52 52 23.3 52 52-23.3 52-52 52z">
                                            </path>
                                        </svg>
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                            viewBox="0 0 1024 1024" height="1.5em" width="1.5em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M923 283.6a260.04 260.04 0 0 0-56.9-82.8 264.4 264.4 0 0 0-84-55.5A265.34 265.34 0 0 0 679.7 125c-49.3 0-97.4 13.5-139.2 39-10 6.1-19.5 12.8-28.5 20.1-9-7.3-18.5-14-28.5-20.1-41.8-25.5-89.9-39-139.2-39-35.5 0-69.9 6.8-102.4 20.3-31.4 13-59.7 31.7-84 55.5a258.44 258.44 0 0 0-56.9 82.8c-13.9 32.3-21 66.6-21 101.9 0 33.3 6.8 68 20.3 103.3 11.3 29.5 27.5 60.1 48.2 91 32.8 48.9 77.9 99.9 133.9 151.6 92.8 85.7 184.7 144.9 188.6 147.3l23.7 15.2c10.5 6.7 24 6.7 34.5 0l23.7-15.2c3.9-2.5 95.7-61.6 188.6-147.3 56-51.7 101.1-102.7 133.9-151.6 20.7-30.9 37-61.5 48.2-91 13.5-35.3 20.3-70 20.3-103.3.1-35.3-7-69.6-20.9-101.9zM512 814.8S156 586.7 156 385.5C156 283.6 240.3 201 344.3 201c73.1 0 136.5 40.8 167.7 100.4C543.2 241.8 606.6 201 679.7 201c104 0 188.3 82.6 188.3 184.5 0 201.2-356 429.3-356 429.3z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <div class="">
                                        <h5 class="card-title fs-1">
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
                                        </h5>
                                        <p class="card-text fs-4">{{ itemdetails?.data?.location?.address_line_1
                                            + " " + itemdetails?.data?.location?.address_line_2
                                            + " " + itemdetails?.data?.location?.city
                                            + " " + itemdetails?.data?.location?.state
                                            + " " + itemdetails?.data?.location?.pincode
                                            + " " + itemdetails?.data?.location?.country?.name }}
                                        </p>
                                    </div>
                                    <div class="">
                                        <!-- <h5 class="card-title fs-3">JAN {{ $itemdetails[0]['crated_at'] }}</h5> -->
                                        <p class="card-text fs-4">1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-body p-2 m-3">
                                <h5 class="card-title fs-1 mb-4 p-0">Details</h5>
                                <div class="d-flex align-items-center gap-20 gap-y-0 mb-2">
                                    <span class="fs-4 w-25">Rent Type</span>
                                    <span class="fs-4">{{ itemdetails?.data?.time }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-20 gap-y-0 mb-2">
                                    <span class="fs-4 w-25">Rent Price</span>
                                    <span class="fs-4">₹ {{ itemdetails?.data?.rent_price }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-20 gap-y-0 mb-2">
                                    <span class="fs-4 w-25">Security Price</span>
                                    <span class="fs-4">₹ {{ itemdetails?.data?.security_price }}</span>
                                </div>
                                <hr>
                                <h5 class="card-title fs-1 mb-4 p-0">Description</h5>

                                <span class="fs-4 w-25" v-html="itemdetails?.data?.description"></span>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-body p-2 m-3">

                                <h5 class="card-title fs-1 mb-4 p-0">Reviews </h5>
                                <span class="fs-4 w-25">Place Rating : 0 average based on 0 reviews.</span>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-body p-2 m-3">
                                <h5 class="card-title fs-1 mb-4 p-0">Found something unusual ?</h5>
                                <span class="fs-4 w-25">Ad Id : {{ itemdetails?.data?.id }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="card mb-3">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <Link class="user_link d-flex align-items-center gap-4"
                                            :href="`/item/user/userProfile/${itemdetails?.data?.user?.id}`">
                                        <img alt="user image" src="/assets/media/avatars/300-1.jpg" width="50" height="50">
                                        <div
                                            class="user_name fs-3 fw-bold text-theme-primary flex-root d-flex align-items-center justify-content-between">
                                            <span>{{ itemdetails?.data?.user?.first_name + " " +
                                                itemdetails?.data?.user?.last_name }}</span>
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 24 24" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                <img alt="user image" src="/assets/image/googlemap.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
    </app-layout>
</template>