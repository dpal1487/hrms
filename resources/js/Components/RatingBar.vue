

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

    props: ['rating', 'initialRating'],
    data() {
        return {
            maxRating: this.rating,
        };
    },
    computed: {
        ratingPercentage() {
            if (this.maxRating != 0) {                
                return (this.initialRating / this.maxRating) * 100;
            }
            else {
                return 0;
            }
        },
    },
    methods: {
    },
};
</script>

<template>
    <!-- {{ initialRating["4_star"]?.length || 0  }} -->
    <div class="flex-root">
        <div class="rating-bar">
            <div class="progress-bar" :style="{ width: ratingPercentage + '%' }"></div>
        </div>
    </div>
</template>