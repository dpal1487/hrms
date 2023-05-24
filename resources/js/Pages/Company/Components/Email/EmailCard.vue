<script>
import { defineComponent } from 'vue';
import 'vue3-toastify/dist/index.css';
export default defineComponent({
    props: ['email'],
})
</script>
<template>
    <!--begin::email-->
    <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
        <div class="d-flex flex-column py-2">
            <!-- {{ company }} -->
            <div class="d-flex align-items-center fs-5 fw-bold mb-5"> Email 
                <!-- {{ company.is_primary }} -->
                <span class="badge badge-light-success fs-7 ms-5" v-if="email?.is_primary == 1">Primary</span>
            </div>

            <div class="fs-6 fw-semibold text-gray-600 m-5">Email ID : {{ email?.email_address}}
                
            </div>
        </div>
        <!--end::Details-->
        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </div>
    <!--end::email-->
</template>
