<script>
import { defineComponent } from 'vue';
import Rating from "../Rating.vue";
export default defineComponent({

    props: ['reviews'],

    data() {
        return {
            rating: 0,
            customer_rating: 0,
            form: {},
            tbody: this.route().current() == 'customer-reviews.index' ? [
                "Name",
                "Title",
                "Content",
                "Rating",
                "IP Address",
            ] : [
                "Name",
                "Title",
                "Content",
                "Rating",
            ],
        }
    },
    components: {
        Rating,
    },
    methods: {

    },

})
</script>

<template>
    <div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-6 gy-5 text-left">
            <thead>
                <tr class="text-gray-800 fw-bold fs-6 text-uppercase">

                    <th v-for="(th, index) in tbody" :key="index">
                        {{ th }}
                    </th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600 text-capitalize">
                <tr v-for="(customer_review, index) in reviews" :key="index">
                    <td><span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                            {{ customer_review?.user?.first_name + " " + customer_review?.user?.last_name }}
                        </span>
                    </td>
                    <td>
                        {{ customer_review?.title }}
                    </td>
                    <td>
                        {{ customer_review?.content }}
                    </td>
                    <td class="text-end" data-order="rating-5">
                        <Rating :rating="customer_review?.rating" />
                    </td>

                    <td v-if="route().current() == ('customer-reviews.index')">
                        {{ customer_review?.ip_address }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>