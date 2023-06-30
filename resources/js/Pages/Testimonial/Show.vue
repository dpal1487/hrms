<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: ['testimonial'],
    data() {
        return {
            title: "Testimonial Overview",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
    },
    methods: {
    },

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
                <Link href="/testimonial" class="text-muted text-hover-primary">Testimonial</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ title }}
            </li>
        </template>

        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> Testimonial Details</h3>
                        <!-- {{ blog }} -->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row">

                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold fs-5 text-gray-800">Name</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <div class="fw-bold fs-6 text-gray-800 text-capitalize">{{
                                    testimonial.data?.name }} </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold fs-5 text-gray-800">Page Name</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <div class="fw-bold fs-6 text-gray-800 text-capitalize"
                                    v-if="this.blog?.data?.is_published == 1">
                                    Published</div>
                                <div class="fw-bold fs-6 text-gray-800 text-capitalize" v-else>Unpublished</div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold fs-5 text-gray-800">Testimonial</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <div class="fw-bold fs-6 text-gray-800 text-capitalize table table-primary"
                                    v-html="testimonial?.data.testimonial">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
