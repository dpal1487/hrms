<script>
import { defineComponent } from 'vue';
import 'vue3-toastify/dist/index.css';
export default defineComponent({
    props: ['contact'],
})
</script>
<template>
        <!--begin::Address-->
        <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
            <div class="d-flex flex-column py-2">
                <!-- {{ company }} -->
                <div class="d-flex align-items-center fs-5 fw-bold mb-5" v-if="contact.is_primary==1">
                    <!-- {{ company.is_primary }} -->
                    <span class="badge badge-light-success fs-7" v-if="contact?.is_primary == 1">Primary</span>
                </div>

                <div class="fs-6 fw-semibold text-gray-600">{{ contact?.name }}
                    <br />{{ contact?.email}}
                    <br />{{ contact?.phone }}
                    <br />{{ contact?.country?.display_name }}
                </div>
            </div>
            <!--end::Details-->
            <!--begin::Actions-->
           <slot name="action"></slot>
            <!--end::Actions-->
        </div>
        <!--end::Address-->
</template>
