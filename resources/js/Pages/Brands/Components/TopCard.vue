
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
<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: ["brand"],
});
</script>
<template>
    <div class="mb-5">
        <div class="card bg-transparent">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-6 rounded  overflow-hidden">
                        <div class="">
                            <img v-if="brand?.image" :src="brand?.image?.small_path" alt="image"
                                class="image-input-wrapper w-100 h-300px" />
                            <img v-else src="/assets/media/svg/avatars/blank.svg" alt="image"
                                class="image-input-wrapper w-100 h-300px">
                        </div>
                        <div class="d-flex flex-column gap-5 p-10 bg-white">
                            <div class="d-flex ">
                                <div class="fs-6  w-50 fw-bold text-gray-800">Name</div>
                                <div class="fs-6  w-50 fw-bold text-gray-700"> {{ brand?.name }}</div>
                            </div>
                            <div class="d-flex ">
                                <div class="fs-6  w-50 fw-bold text-gray-800"> Slug</div>
                                <div class="fs-6  w-50 fw-bold text-gray-700"> {{ brand?.slug }}</div>
                            </div>
                            <div class="d-flex ">
                                <div class="fs-6  w-50 fw-bold text-gray-800">Category</div>
                                <div class="fs-6  w-50 fw-bold text-gray-700">
                                    <span class="badge badge-secondary">
                                    {{ brand?.category?.name }}</span></div>
                            </div>
                            <div class="d-flex ">
                                <div class="fs-6  w-50 fw-bold text-gray-800">Description</div>
                                <div class="fs-6  w-50 fw-bold text-gray-700"> <span v-html="brand?.description"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h-100 d-flex justify-content-center align-items-center bg-gray-100">
                            <div class="drop-shadow">
                                <div class="text-center bg-white p-20 rhombus">
                                    <div>
                                        <div class="badge bg-success">Active</div>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h1>{{ brand?.header?.total_active }}&nbsp;</h1>
                                            <span>Out Of</span>
                                            <h1>&nbsp;{{ brand?.header?.total_value }}</h1>
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
