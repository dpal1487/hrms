<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: ["attribute"],
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
                    <h2>Attribute</h2>
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
                                        {{ attribute?.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Data Type
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ attribute?.data_type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Category
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ attribute?.category?.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Field
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ attribute?.field }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">
                                        Input Type
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ attribute?.type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Attribute Rules
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700 text-right">
                                        <span class="" v-for="rule in attribute?.rules">
                                            <p>
                                                Message:
                                                {{ rule?.message }}
                                            </p>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fs-6 fw-bold text-gray-800">

                                        Description
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700 whitespace-break">
                                        <span v-html="attribute?.description"></span>
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
                                        <div class="badge bg-success w-fit">Active</div>
                                        <div class="d-flex justify-content-center align-items-center text-gray-600">
                                            <h1 class="text-gray-800">{{ attribute?.header?.total_active }}&nbsp;</h1>
                                            <span>Out Of</span>
                                            <h1 class="text-gray-800">&nbsp;{{ attribute?.header?.total_value }}</h1>
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
