
<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link
    },
    data() {
        return {

        };
    },

    methods: {

    },
    created(){
       var body = document.getElementById('app_body');
       body.style.justifyContent='center'
    }
});
</script>

<template>
    <div class="d-flex flex-column flex-root justify-content-center flex h-100">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div
                    class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100"
                >
                    <!--begin::Image-->
                    <img
                        class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="/assets/media/auth/agency.png"
                        alt=""
                    />
                    <img
                        class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="/assets/media/auth/agency-dark.png"
                        alt=""
                    />
                    <!--end::Image-->

                    <!--begin::Title-->
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                        Fast, Efficient and Productive
                    </h1>
                    <!--end::Title-->

                    <!--begin::Text-->
                    <div class="text-gray-600 fs-base text-center fw-semibold">
                        In this kind of post,
                        <Link href="#" class="opacity-75-hover text-primary me-1"
                            >the blogger</Link
                        >

                        introduces a person they’ve interviewed <br />
                        and provides some background information about

                        <Link href="#" class="opacity-75-hover text-primary me-1"
                            >the interviewee</Link
                        >
                        and their <br />
                        work following this is a transcript of the interview.
                    </div>
                    <!--end::Text-->
                </div>
            </div>
                <div
                    class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12"
                >
                    <div
                        class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10"
                    >
                        <div
                            class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px"
                        >
                            <div
                                class="d-flex flex-center flex-column-fluid pb-15 pb-lg-20"
                            >
                                <slot />
                            </div>
                            <div class="d-flex flex-stack">
                                <!--begin::Links-->
                                <div
                                    class="d-flex fw-semibold text-primary fs-base gap-5"
                                >
                                    <Link
                                        href="/"
                                        target="_blank"
                                        >Terms</Link
                                    >

                                    <Link
                                        href="/"
                                        target="_blank"
                                        >Plans</Link
                                    >

                                    <Link
                                        href="/"
                                        target="_blank"
                                        >Contact Us</Link
                                    >
                                </div>
                                <!--end::Links-->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>
