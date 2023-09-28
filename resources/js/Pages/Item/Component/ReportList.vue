<script>
import { defineComponent } from "vue";
import Pagination from "../../../Jetstream/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ["reports"],

    data() {
        return {
            tbody: [
                "Title",
                "Content",
                "User",
                "Action",
            ],
        };
    },
    components: {
        Pagination,
        Link
    },
    methods: {
    },
});
</script>
<template>
    
    <div class="card card-flush">
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-center table-row-dashed fs-5 gy-5">
                    <thead>
                        <tr class="text-gray-800 fw-bold fs-5 text-uppercase">
                            <th v-for="(th, index) in tbody" :key="index">
                                {{ th }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-700 text-capitalize">
                        <tr v-for="(report, index) in reports" :key="index">
                            <td>
                                {{ report?.review_title}}
                            </td>
                            <td>
                                {{ report?.review_content }}
                            </td>
                            <td>
                                {{ report?.user?.first_name }} {{ report?.user?.last_name }}
                            </td>
                            <td>
                                <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                    report?.id, index
                                )
                                    ">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="reports.meta">
                <Pagination :links="reports.meta.links" />
            </div>
        </div>
    </div>
</template>
