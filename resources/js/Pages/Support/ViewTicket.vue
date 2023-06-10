<script>
import { defineComponent } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';
import moment from "moment";
import Pagination from '../../Jetstream/Pagination.vue';

export default defineComponent({
    props: ['employees', 'ticket'],
    data() {
        return {
            moment: moment,
            date: moment(this.ticket?.data?.created_at).format("YYYY-MM-DD HH:MM"), // Replace with your own date
        };
    },
    computed: {
        daysSinceLastDate() {
            const currentDate = new Date()
            const previousDate = new Date(this.date)
            const timeDifference = currentDate.getTime() - previousDate.getTime()
            const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24))
            return daysDifference
        },
    },
    components: {
    AppLayout,
    Header,
    Link,
    Pagination
}
})
</script>


<template>
    <AppLayout>
        <Header :employees="employees.data" />
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support" class="text-muted text-hover-primary">Support</Link>
            </li>
        </template>
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <!--begin::Ticket view-->
            <div class="mb-0">
                <!--begin::Comments-->

                <!--begin::Card-->
                <div class="card card-bordered w-100">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Wrapper-->
                        <div class="w-100 d-flex flex-stack mb-8">
                            <!--begin::Container-->
                            <div class="d-flex align-items-center f">
                                <!--begin::Author-->
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label fs-1 fw-bold bg-light-success text-success">
                                        {{ ticket?.data?.name }}</div>
                                </div>
                                <!--end::Author-->
                                <!--begin::Info-->
                                <div class="d-flex flex-column fw-semibold fs-5 text-gray-600 text-dark">
                                    <!--begin::Text-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Username-->
                                        <a href="#"
                                            class="text-gray-800 fw-bold text-hover-primary fs-5 me-3 text-capitalize"> {{
                                                ticket?.data?.subject }}</a>
                                        <!--end::Username-->
                                        <span class="m-0">{{ ticket?.data?.email }}</span>
                                    </div>
                                    <!--end::Text-->
                                    <!--begin::Date-->

                                    <span class="text-muted fw-semibold fs-6"> {{ daysSinceLastDate }} Days ago </span>
                                    <!--end::Date-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Container-->
                            <!--begin::Actions-->
                            <div class="m-0">
                                <button class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bold">Reply</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Desc-->
                        <p class="fw-normal fs-5 text-gray-700 m-0">{{ ticket?.data?.description }}.</p>
                        <!--end::Desc-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Comments-->
                <!--begin::Pagination-->
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="ticket.meta">
                    <Pagination :links="ticket.meta.links" />
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Ticket view-->
        </div>
    </AppLayout>
</template>