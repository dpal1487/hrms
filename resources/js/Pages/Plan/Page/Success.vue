<style>
body {
    background-image: url('../../assets/media/auth/bg8.jpg');
}

[data-theme="dark"] body {
    background-image: url('../../assets/media/auth/bg8-dark.jpg');
}
</style>
<script>
import { defineComponent } from 'vue';

import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: { Link }
})
</script>
<template>
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-md-650px py-5">
                    <div class="card-body py-15 py-lg-20">

                        <!--begin::Logo-->
                        <div class="mb-7">
                            <a href="#" class="">
                                <img alt="Logo" src="/assets/media/logos/custom-2.svg" class="h-40px" />
                            </a>
                        </div>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder text-gray-900 mb-5">Welcome to Metronic</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="fw-semibold fs-6 text-gray-500 mb-7">This is your opportunity to get creative and
                            make a name
                            <br />that gives readers an idea
                        </div>
                        <!--end::Text-->
                        <!--begin::Illustration-->
                        <div class="mb-0">
                            <img src="/assets/media/auth/welcome.png" class="mw-100 mh-300px theme-light-show" alt="" />
                            <img src="/assets/media/auth/welcome-dark.png" class="mw-100 mh-300px theme-dark-show" alt="" />
                        </div>
                        <!--end::Illustration-->
                        <!--begin::Link-->
                        <div class="mb-0">
                            <Link href="/plan" class="btn btn-sm btn-primary">Go To Dashboard</Link>
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