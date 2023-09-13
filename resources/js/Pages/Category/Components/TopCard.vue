<script>
import { defineComponent } from "vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import ImageInput from '@/Components/ImageInput.vue';

export default defineComponent({
    props: ["category"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                thumbnail: { required },
                banner_image: { required },
            },
        };
    },
    data() {
        return {
            thumbnail: {
                isLoading: false,
                url: null,
            },
            form: this.$inertia.form({
                id: this.category?.data?.id || '',
                image_id: this.category?.image?.id ? this.category?.image?.id : this.form?.image_id,
                banner_image: this.category?.data?.banner?.id ? this.category?.data?.banner?.id : this.form?.banner_image,
            }),
        };
    },
    components: {
        ImageInput
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

<style>
.rhombus {
    clip-path: polygon(50% 0%, 0% 50%, 50% 100%, 100% 50%);
    width: 250px;
    height: 250px;
    display: grid;
    place-content: center;
}

.drop-shadow {
    filter: drop-shadow(0 0 20px rgb(204, 253, 230));
}
</style>

<template>
    <div class="mb-5">
        <div class="card">
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Category</h2>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-striped table-bordered text-left mx-10 align-middle text-capitalize">
                            <tbody>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Name
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ category?.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Keyword
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ category?.keywords }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Description
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        <span v-html="category?.description"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Meta
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ category?.meta?.tag }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Meta Keyword
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700 text-right">
                                        {{ category?.meta?.keywords }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Meta Description
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700 whitespace-break">
                                        <span v-html="category?.meta?.description"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Image
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        <div
                                            class="d-block symbol symbol-150px symbol-lg-150px symbol-fixed position-relative m-5">
                                            <ImageInput :image="this.category?.image?.small_path"
                                                :onchange="onThumbnailChange" :remove="removeSelectedAvatar"
                                                :selectedImage="thumbnail.url" :errors="v$.form.thumbnail.$errors"
                                                :isUploading="thumbnail.isLoading" />
                                            <!-- <img v-if="category?.image" :src="category?.image?.small_path" alt="image"
                                                class="rounded" />
                                            <img v-else src="/assets/media/svg/avatars/blank.svg" alt="image"
                                                class="rounded"> -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <!-- {{ category }} -->
                        <div class="h-100 d-flex justify-content-center align-items-center bg-gray-100">
                            <div class="drop-shadow">
                                <div class="text-center bg-white p-20 rhombus ">
                                    <div>
                                        <div class="badge bg-success w-fit">Active</div>
                                        <div class="d-flex justify-content-center align-items-center text-gray-600">
                                            <h1 class="text-gray-800">{{ category?.header?.total_active }}&nbsp;</h1>
                                            <span>Out Of</span>
                                            <h1 class="text-gray-800">&nbsp;{{ category?.header?.total_value }}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
