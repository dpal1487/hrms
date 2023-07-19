
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
        <div class="card">
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Brand</h2>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-striped table-bordered text-left align-middle">
                            <tbody>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Name
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ brand?.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Slug
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ brand?.slug }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Category
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ brand?.category?.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Description
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700 whitespace-break">
                                        <span v-html="brand?.description"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Image
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        <div
                                            class="d-block symbol symbol-150px symbol-lg-150px symbol-fixed position-relative">
                                            <img v-if="brand?.image" :src="brand?.image?.small_path" alt="image"
                                                class="rounded" />
                                            <img v-else src="/assets/media/svg/avatars/blank.svg" alt="image"
                                                class="rounded">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
</div></template>
