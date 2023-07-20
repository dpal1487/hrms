<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: ["faq_category"],
});
</script>
<style>
.rhombus {
    clip-path: polygon(50% 0%, 0% 50%, 50% 100%, 100% 50%);
    width: 150px;
    height: 150px;
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
                    <h2>FAQs Category</h2>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-striped table-bordered mx-10 text-left align-middle">
                            <tbody>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Title
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ faq_category?.title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Slug
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ faq_category?.slug }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Image
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        <div
                                            class="d-block symbol symbol-150px symbol-lg-150px symbol-fixed position-relative">
                                            <img v-if="faq_category?.image" :src="faq_category?.image?.small_path"
                                                alt="image" class="rounded" />
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
                                        <h1>{{ faq_category?.header?.total }}</h1>

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
