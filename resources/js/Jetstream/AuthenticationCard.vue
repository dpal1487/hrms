
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
    <div class="d-flex flex-column flex-root justify-content-center flex h-md-100">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div
                    class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100"
                >
                    <!--begin::Image-->
                    <img
                        class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20 mb-md-20"
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
                                <!--begin::Languages-->
                                <div class="me-10">
                                    <!--begin::Toggle-->
                                    <button
                                        class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                                        data-kt-menu-trigger="click"
                                        data-kt-menu-placement="bottom-start"
                                        data-kt-menu-offset="0px, 0px"
                                    >
                                        <img
                                            data-kt-element="current-lang-flag"
                                            class="w-20px h-20px rounded me-3"
                                            src="/assets/media/flags/united-states.svg"
                                            alt=""
                                        />

                                        <span
                                            data-kt-element="current-lang-name"
                                            class="me-1"
                                            >English</span
                                        >

                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span
                                            class="svg-icon svg-icon-5 svg-icon-muted rotate-180 m-0"
                                            ><svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor"
                                                ></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Toggle-->

                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                                        data-kt-menu="true"
                                        id="kt_auth_lang_menu"
                                    >
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a
                                                href="#"
                                                class="menu-link d-flex px-5"
                                                data-kt-lang="English"
                                            >
                                                <span
                                                    class="symbol symbol-20px me-4"
                                                >
                                                    <img
                                                        data-kt-element="lang-flag"
                                                        class="rounded-1"
                                                        src="/assets/media/flags/united-states.svg"
                                                        alt=""
                                                    />
                                                </span>
                                                <span
                                                    data-kt-element="lang-name"
                                                    >English</span
                                                >
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a
                                                href="#"
                                                class="menu-link d-flex px-5"
                                                data-kt-lang="Spanish"
                                            >
                                                <span
                                                    class="symbol symbol-20px me-4"
                                                >
                                                    <img
                                                        data-kt-element="lang-flag"
                                                        class="rounded-1"
                                                        src="/assets/media/flags/spain.svg"
                                                        alt=""
                                                    />
                                                </span>
                                                <span
                                                    data-kt-element="lang-name"
                                                    >Spanish</span
                                                >
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a
                                                href="#"
                                                class="menu-link d-flex px-5"
                                                data-kt-lang="German"
                                            >
                                                <span
                                                    class="symbol symbol-20px me-4"
                                                >
                                                    <img
                                                        data-kt-element="lang-flag"
                                                        class="rounded-1"
                                                        src="/assets/media/flags/germany.svg"
                                                        alt=""
                                                    />
                                                </span>
                                                <span
                                                    data-kt-element="lang-name"
                                                    >German</span
                                                >
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a
                                                href="#"
                                                class="menu-link d-flex px-5"
                                                data-kt-lang="Japanese"
                                            >
                                                <span
                                                    class="symbol symbol-20px me-4"
                                                >
                                                    <img
                                                        data-kt-element="lang-flag"
                                                        class="rounded-1"
                                                        src="/assets/media/flags/japan.svg"
                                                        alt=""
                                                    />
                                                </span>
                                                <span
                                                    data-kt-element="lang-name"
                                                    >Japanese</span
                                                >
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a
                                                href="#"
                                                class="menu-link d-flex px-5"
                                                data-kt-lang="French"
                                            >
                                                <span
                                                    class="symbol symbol-20px me-4"
                                                >
                                                    <img
                                                        data-kt-element="lang-flag"
                                                        class="rounded-1"
                                                        src="/assets/media/flags/france.svg"
                                                        alt=""
                                                    />
                                                </span>
                                                <span
                                                    data-kt-element="lang-name"
                                                    >French</span
                                                >
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Languages-->

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
