

<style scoped>
.rating-bar {
    width: 100%;
    height: 12px;
    background-color: #e1ded1;
    border-radius: 15px;
}

.progress-bar {
    height: 100%;
    background-color: #fecc06;
    transition: width 0.3s ease-in-out;
    border-radius: 15px;

}
</style>
<script>
export default {
    props: {
        initialRating: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            rating: this.initialRating,
            maxRating: 100,
        };
    },
    computed: {
        ratingPercentage() {
            return (this.rating / this.maxRating) * 100;
        },
    },
    methods: {
    },
};
</script>

<template>
    <div class="flex-root">
        <div class="rating-bar">
            <div class="progress-bar" :style="{ width: ratingPercentage + '%' }"></div>
        </div>
    </div>
</template>