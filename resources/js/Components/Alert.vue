<script>
import { defineComponent } from 'vue';
export default defineComponent({
    props: ["type"]
})
</script>

<template>
    <div
        :class="`alert bg-light-success border-success border  d-flex flex-column flex-sm-row align-items-sm-center py-0 mb-10`">
        <!-- replace with icon -->
        
        <!--begin::Wrapper-->
        <div :class="`d-flex flex-column text-success  pe-0`">
            <!--begin::Title-->
            {{ $page.props.ziggy.flash.message }}
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button"
            :class="`position-absolute position-sm-relative m-2 m-sm-0 top-0 text-success end-0 btn btn-icon ms-sm-auto`"
            data-bs-dismiss="alert">
            <svg stroke="currentColor" fill="currentColor" stroke-width="1" version="1.1" viewBox="0 0 17 17" height=".8em"
                width=".8em" xmlns="http://www.w3.org/2000/svg">
                <g></g>
                <path
                    d="M9.207 8.5l6.646 6.646-0.707 0.707-6.646-6.646-6.646 6.646-0.707-0.707 6.646-6.646-6.647-6.646 0.707-0.707 6.647 6.646 6.646-6.646 0.707 0.707-6.646 6.646z">
                </path>
            </svg>
        </button>
        <!--end::Close-->
    </div>
</template>