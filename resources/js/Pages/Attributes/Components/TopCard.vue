<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: ["attribute"],
});
</script>
<template>
    <div class="mb-5">
        <div class="card">
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Attribute</h2>
                </div>
            </div>
            <div class="card-body pt-9 pb-0">
                <div class="row">

                    <div class="col-6">
                        <table class="table table-striped table-bordered text-center align-middle">
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

                                        Display Order
                                    </th>
                                    <td class="fs-6 fw-bold text-gray-700">
                                        {{ attribute?.display_order }}
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
                            <div class="text-center">
                                <div class="badge bg-success">Active</div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <h1>{{ attribute?.header?.total_active }}&nbsp;</h1>
                                    <span>Out Of</span>
                                    <h1>&nbsp;{{ attribute?.header?.total_value }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
