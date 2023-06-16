
<style>
body {
    background-image: url('../../assets/media/auth/bg7.jpg');
}

[data-theme="dark"] body {
    background-image: url('../../assets/media/auth/bg7-dark.jpg');
}
</style>
<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';


export default defineComponent({
    components: {

        Link
    }
})
</script>
<template>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->

        <!--end::Page bg image-->
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-lg-650px py-5">
                    <div class="card-body py-15 py-lg-20">
                        <!--begin::Title-->
                        <h1 class="fw-bolder fs-2qx text-gray-900 mb-4">System Error</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="fw-semibold fs-6 text-gray-500 mb-7">Something went wrong! Please try again later.
                        </div>
                        <!--end::Text-->
                        <!--begin::Illustration-->
                        <div class="mb-11">
                            <img src="/assets/media/auth/500-error.png" class="mw-100 mh-300px theme-light-show" alt="" />
                            <img src="/assets/media/auth/500-error-dark.png" class="mw-100 mh-300px theme-dark-show"
                                alt="" />
                        </div>
                        <!--end::Illustration-->
                        <!--begin::Link-->
                        <div class="mb-0">

                            <Link href="/plan" class="btn btn-sm btn-primary">Return Home</Link>
                        </div>
                        <!--end::Link-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
</template>