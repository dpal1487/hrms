<script>
import { defineComponent } from 'vue';
import InputError from "@/jetstream/InputError.vue";


export default defineComponent({
    props: ["image", "selectedImage", "errors"],
    components: {
        InputError,
    },
    methods: {
        handleRemoveClick() {
            alert("slkdfj")
            this.$emit("remove");
            alert("sldkfj");
        }
    }
})
</script>


<template>
    <div class="d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="image-input image-input-outline mx-auto" data-kt-image-input="true"
                style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                <!--begin::Preview existing avatar-->
                <!-- {{ this.industry?.data?.image?.medium_path }} -->
                <img class="image-input-wrapper w-125px h-125px" v-if="image && !selectedImage" :src="image" />
                <img class="image-input-wrapper w-125px h-125px" v-else-if="!this.industry && !selectedImage"
                    src="/assets/media/svg/avatars/blank.svg" />
                <img class="image-input-wrapper w-125px h-125px" v-else :src="selectedImage" />


                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <!--begin::Inputs-->
                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" @change="$emit('onchange')" />
                    <!-- <input type="hidden" name="avatar_remove" /> -->
                    <!--end::Inputs-->
                </label>
                <div v-for="(error, index) of errors" :key="index">
                    <!-- {{ error.$message }} -->
                    <input-error :message="error.$message" />
                </div>
                <!--end::Label-->
                <!--begin::Cancel-->
                <button type="button" v-if="selectedImage"
                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Cancel avatar"
                    @click="handleRemoveClick">
                    <i class="bi bi-x fs-2"></i>
                </button>
                <!--end::Cancel-->
            </div>
            <div class="form-text mt-5">Allowed file types: png, jpg, jpeg.</div>
        </div>
    </div>
</template>
