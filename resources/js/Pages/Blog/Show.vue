<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url, integer } from "@vuelidate/validators";
import ImageInput from '@/components/ImageInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { toast } from 'vue3-toastify';

export default defineComponent({
    props: ['blog'],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {

        };

    },


    data() {
        return {
            title: "Blog Overview",
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
    <Head title="Blog Overview" />
    <AppLayout title="Blog Overview">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/blog" class="text-muted text-hover-primary">Blog</Link>
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
            <!--begin::Navbar-->
            <!-- {{ $page }} -->
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> Blog Details</h3>
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
                            <label class="col-lg-4 fw-bold fs-5 text-gray-800">Title</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <div class="fw-bold fs-6 text-gray-800 text-capitalize">{{
                                    this.blog?.data?.title }} </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold fs-5 text-gray-800">Status</label>
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
                            <label class="col-lg-4 fw-bold fs-5 text-gray-800">Content</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <div class="fw-bold fs-6 text-gray-800 text-capitalize table table-primary"
                                    v-html="blog?.data.content">
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
