<script>
import { defineComponent } from "vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import ImageInput from '@/Components/ImageInput.vue';
import utils from "../../utils";
import { toast } from "vue3-toastify";

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
                id: this.category?.id || '',
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
            const data = await utils.imageUpload(route('category.thumbnail'), e, this.form.image_id, this.form.id)
            if (data.response.success) {
                this.form.image_id = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }

            this.thumbnail.url = URL.createObjectURL(data.file);

            this.thumbnail.isLoading = false;
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
                    <div class="col-12 col-md-6 col-sm-6 text-capitalize mt-5">
                        <div class="d-flex justify-content-between align-items-center mx-10 text-gray-600">
                            <div class="fs-6 fw-bold text-gray-800 w-100 ">Name</div>
                            <div class="fs-6 fw-bold text-gray-700 flex justify-start w-100 ">{{ category?.name }}</div>
                        </div>
                        <!-- <hr class="mx-10"> -->
                        <div class="d-flex m-4 justify-content-between align-items-center mx-10 text-gray-600">
                            <div class="fs-6 fw-bold text-gray-800 w-100">Keyword</div>
                            <div class="fs-6 fw-bold text-gray-700  w-100">{{ category?.keywords }}</div>
                        </div>
                        <!-- <hr class="mx-10"> -->
                        <div class="d-flex m-4 justify-content-between align-items-center mx-10 text-gray-600">
                            <div class="fs-6 fw-bold text-gray-800 w-100">Description</div>
                            <div class="fs-6 fw-bold text-gray-700 w-100 "><span v-html="category?.description"></span></div>
                        </div>
                        <!-- <hr class="mx-10"> -->
                        <div class="d-flex m-4 justify-content-between align-items-center mx-10 text-gray-600">
                            <div class="fs-6 fw-bold text-gray-800 w-100">Meta</div>
                            <div class="fs-6 fw-bold text-gray-700  w-100">{{ category?.meta?.tag }}</div>
                        </div>
                        <!-- <hr class="mx-10"> -->
                        <div class="d-flex m-4 justify-content-between align-items-center mx-10 text-gray-600">
                            <div class="fs-6 fw-bold text-gray-800 w-100">Meta Keyword</div>
                            <div class="fs-6 fw-bold text-gray-700  w-100">{{ category?.meta?.keywords }}</div>
                        </div>
                        <!-- <hr class="mx-10"> -->
                        <div class="d-flex m-4 justify-content-between align-items-center mx-10 text-gray-600">
                            <div class="fs-6 fw-bold text-gray-800 w-100">Meta Description</div>
                            <div class="fs-6 fw-bold text-gray-700  w-100"> <span v-html="category?.meta?.description"></span>
                            </div>
                        </div>
                        <!-- <hr class="mx-10"> -->
                        <div class="d-block symbol symbol-150px symbol-lg-150px symbol-fixed position-relative my-10 ">
                            <ImageInput :image="this.category?.image?.small_path" :onchange="onThumbnailChange"
                                :remove="removeSelectedAvatar" :selectedImage="thumbnail.url"
                                :errors="v$.form.thumbnail.$errors" :isUploading="thumbnail.isLoading" page="topCard"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-sm-6">
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
