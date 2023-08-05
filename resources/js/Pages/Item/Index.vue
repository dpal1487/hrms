<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import ItemCard from "./Component/ItemCard.vue";
export default defineComponent({
    props: ["items", 'itemStatus'],
    data() {
        return {
            form: {},
            selectAll: false,
            title: "Items",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        Loading,
        ItemCard
    },
    methods: {

        search() {
            Inertia.get(
                "/items",
                this.form,
            );
        },

    },
});
</script>
<template>
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Items</span>
            </li>
        </template>

        <Head :title="title" />
        <div class="card card-flush">
            <form @submit.prevent="search" class="card-header justify-content-start py-4 px-4 gap-2 gap-md-5">
                <div class="d-flex align-items-center position-relative">
                    <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                        placeholder="Search Project" />
                </div>
                <div class="w-100 mw-200px">
                    <Multiselect :can-clear="false" :options="itemStatus.data" label="label" valueProp="id"
                        class="btn btn-sm btn-light py-2 px-0" placeholder="Select Status" v-model="form.s" />
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <ItemCard :items="items.data" pagename="items" />
        <div class="row mt-5" v-if="items.meta">
            <div class="col-sm-12 d-flex align-items-center justify-content-between">
                <span class="fw-bold text-gray-700">
                    Showing {{ items.meta.from }} to
                    {{ items.meta.to }} of {{ items.meta.total }} entries
                </span>
                <Pagination :links="items.meta.links" />
            </div>
        </div>

    </app-layout>
</template>
