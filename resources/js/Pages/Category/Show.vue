<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import TopCard from "./Components/TopCard.vue";
export default defineComponent({
    props: ["category"],
    setup() {
    },
    validations() {
        return {
            form: {
                image: {
                    required
                }
            }
        };
    },
    data() {
        return {

            tbody: [
                "Name",
                "Description",
                "Status",
            ],
            title: "Category Overview",
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        TopCard,
    },
    methods: {

        async onThumbnailChange(e) {
            this.thumbnail.isLoading = true;
            const data = await utils.imageUpload(route('category.thumbnail'), e, this.form.image_id)

            if (data.response.success) {
                this.form.image_id = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }

            this.thumbnail.url = URL.createObjectURL(data.file);

            this.thumbnail.isLoading = false;
        },

        async onBannerChange(e) {
            console.log(this.form.banner_image)
            this.banner.isLoading = true;
            const data = await utils.imageUpload(route('category.banner'), e, this.form.banner_image)
            if (data.response.success) {
                this.form.banner_image = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }
            this.banner.url = URL.createObjectURL(data.file);

            this.banner.isLoading = false;
        },

        removeSelectedAvatar() {
            this.url = null;
        }
    },
});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <Link href="/categories" class="text-muted text-hover-primary">Categories</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Category Overview
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/category/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Category</Link>
            </div>
        </template>
        <div>
            <TopCard :category="category?.data" />
            <div class="card mt-5">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Category Banner</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <img v-if="category?.data?.banner" :src="category?.data?.banner?.file_path" alt="image"
                                class="w-100 h-300px" />
                            <img v-else src="/assets/media/misc/pattern-4.jpg" alt="image" class="w-100 h-300px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Category Attribute</h2>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 text-left mx-10">
                                    <thead>
                                        <tr class="text-gray-800 fw-bold text-uppercase">
                                            <th v-for="(th, index) in tbody" :key="index">
                                                {{ th }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-700 text-capitalize">
                                        <tr v-for="(attribute, index) in category?.data?.attributes" :key="index">
                                            <td>
                                                {{ attribute?.name }}
                                            </td>
                                            <td v-html="attribute?.description ">
                                                
                                            </td>
                                            <td>
                                                <div class="badge bg-success w-fit" v-if="attribute?.status == 1">Active
                                                </div>
                                                <div class="badge bg-danger w-fit" v-else>Inactive</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
