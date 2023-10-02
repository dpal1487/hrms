<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ['address', 'user'],
    data() {
        return {
            title: "Address",
        };
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
    },
    methods: {
    }
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
                <Link href="/users" class="text-muted text-hover-primary">Users</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="text-muted">
                {{ user?.data?.first_name }}
            </li>
        </template>
        <Header :user="user?.data" :address="address?.data" />

        <div class="col-md-6 col-xxl-4">
            <!--begin::Card-->
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <label class="col-12 fs-4 text-capitalize text-gray-800"> <i class="fa-solid fa-user-tie"></i>
                            <span class="text-gray-600 fs-6 mx-5">{{ address?.data?.name }}</span>
                        </label>
                        <label><i class="fas fa-fw fa-phone"></i> <span class="text-gray-600 fs-6 mx-2">
                                {{ address?.data?.phone }}</span>
                        </label>
                        <label class="fs-6 text-gray-600 text-capitalize"><i class="fa-regular fa-address-card"></i>
                            <span class="mx-5">{{ address?.data?.address }}</span>
                            <span>{{ address?.data?.city }}</span>
                            <span class="mx-2">{{ address?.data?.state }}</span>
                        </label>
                        <label class="col-6"> <span class="fs-6 text-gray-600">{{ address?.data?.pincode }}</span></label>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </AppLayout>
</template>
