<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ['plan'],
    components: {
        AppLayout,
        Header,
        Link,
        Head,
    },
    data() {
        return {
            title: "Plan Overview",
            null: '',
        };
    },
    methods: {
    },
});
</script>
<template>
    <Head :title="title" />
    <AppLayout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/plans" class="text-muted text-hover-primary">Plans</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="text-muted">
                {{ plan?.data?.name }}
            </li>
        </template>
        <Header :plan="plan?.data" />
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Plan Details</h3>
                </div>
            </div>
            <div class="card-body p-9 text-capitalize">
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Plan Name</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.name }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Plan Price</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.price }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Category</label>
                    <div class="col-6 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2">{{ plan?.data?.category?.name }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Period</label>
                    <div class="col-6 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2">
                            {{ plan?.data?.period }}
                        </span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Number Of Days</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.no_of_ads }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Interval</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.interval }}</span>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Plan Id</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.plan_id }}</span>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Sort Description</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.sort_description }}</span>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Currency</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.currency }}</span>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Description</label>
                    <div class="col-6" v-if="(plan?.data?.description != null)">
                        <span class="fw-bold fs-6 text-gray-800"
                            v-for="(description) in JSON.parse(plan?.data?.description)">{{ description?.description
                            }}</span>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Created At</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.created_at }}</span>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Updated At</label>
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ plan?.data?.updated_at }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
