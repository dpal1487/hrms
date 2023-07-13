<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import axios from "axios";
import ItemCard from "./Component/ItemCard.vue";
export default defineComponent({
    props: ["items", 'itemStatus'],
    data() {
        return {
            form: {},
            selectAll: false,
            title: "Item",
            tbody: [
                "Industry Name",
                "Industry Image",
                "Status",
                "Action",
            ],
            checkbox: [],
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

        confirmDelete(id, index) {
            this.isLoading = true;
            const name = this.industries.data[index].name;
            Swal.fire({
                title: "Are you sure you want to delete " + name + " ?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete("/industry/" + id)
                        .then((response) => {
                            toast.success(response.data.message);
                            if (response.data.success) {
                                this.industries.data.splice(index, 1);
                                return;
                            }
                        })
                        .catch((error) => {
                            if (error.response.status == 400) {
                                toast.error(error.response.data.message);
                            }
                        });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: + name + "was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }

            });
        },
        search() {
            Inertia.get(
                "/item",
                this.form,
            );
        },
        changeStatus(e, id) {
            this.isLoading = true;
            axios
                .post("/industry/status", { id: id, status: e })
                .then((response) => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        return;
                    }
                    toast.error(response.data.message);
                })
                .finally(() => (this.isLoading = false));
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
                <Link href="/item" class="text-muted text-hover-primary">Item</Link>
            </li>
        </template>

        <Head :title="title" />
        <div class="card mb-5 mb-xxl-5 bg-white">

            <form class="card-header align-items-center py-5 gap-2 gap-md-5" @submit.prevent="search()">
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
                        placeholder="Search " />
                </div>
                <div class="w-100 mw-200px">
                    <Multiselect :options="itemStatus.data" label="label" valueProp="id" @change="changeStatus"
                        class="form-control form-control-solid" placeholder="Select Status" v-model="form.s" />
                </div>
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                </div>
            </form>
            <div v-for="item in items.data" class="mb-5">
                <ItemCard :item="item" />
            </div>
            <div class="d-flex align-items-center justify-content-center" v-if="items?.meta">
                <Pagination :links="items?.meta.links" />
            </div>
        </div>
    </app-layout>
</template>
