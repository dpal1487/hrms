
<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import Vue3autocounter from 'vue3-autocounter';
export default defineComponent({
    props: ['question', 'answers'],
    components: {
        Link,
        Vue3autocounter
    },
    data() {

    },
    methods: {
        // result: this.?answers.lenght

    }
});
</script>
<template>
    <div v-for="(answer, index) in answers.data">

    </div>


    <div class="card mb-5 mb-xl-5">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Stats-->

                    <div class="d-flex flex-wrap flex-stack">

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold">
                                            <Vue3autocounter ref='counter' :startAmount='0' :endAmount='2021' :duration='3'
                                                separator=',' :autoinit='true' />
                                        </div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-bold fs-6 text-gray-900">Answwers</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
        </div>
    </div>
</template>
