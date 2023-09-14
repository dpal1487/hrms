<style>
.close-container {
    display: none;
    place-content: center;
}

.image-hover:hover .close-container {
    display: grid !important;
}
</style>
<template>
    <div :class="`dropzone ${files.length > 0 || isDefaultImage ? 'h-300px' : 'h-150px'} position-relative`">
        <div class="w-100" @dragover="dragover" @dragleave="dragleave" @drop="drop">
            <input type="file" :multiple="multiple" name="file" id="fileInput" class="d-none" @change="onChange" ref="file"
                accept=".pdf,.jpg,.jpeg,.png" />

            <label v-if="files.length === 0 && !isDefaultImage" for="fileInput"
                class="position-absolute w-100 h-100 top-0 start-0 d-flex flex-column gap-4 align-items-center justify-content-center">
                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                <div class="file-label">
                    <div v-if="isDragging">Release to drop files here.</div>
                    <div v-else>Drop files here or click to upload.</div>
                </div>
            </label>

            <div v-else-if="isUploading"
                class="position-absolute w-100 h-100 top-0 start-0 d-flex align-items-center justify-content-center">
                <div class="spinner-border spinner-border-sm w-50px h-50px"></div>
            </div>

            <div class="position-absolute image-hover w-100 h-100 top-0 start-0" v-else-if="isDefaultImage">
                <img style="z-index: 1;" class="position-absolute top-0 start-0 w-100 h-100" :src="image"
                    alt="preview image" />
                <div style="z-index: 2; background-color: rgba(0, 0, 0, 0.365);"
                    class="position-absolute top-0 start-0 close-container w-100 h-100">
                    <button type="button" @click="removeDefaultImage()"
                        class="border-0 outline-0 d-flex align-items-center justify-content-center w-50px h-50px bg-transparent text-danger">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="40px"
                            width="40px" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path
                                        d="M9.525,13.765a.5.5,0,0,0,.71.71c.59-.59,1.175-1.18,1.765-1.76l1.765,1.76a.5.5,0,0,0,.71-.71c-.59-.58-1.18-1.175-1.76-1.765.41-.42.82-.825,1.23-1.235.18-.18.35-.36.53-.53a.5.5,0,0,0-.71-.71L12,11.293,10.235,9.525a.5.5,0,0,0-.71.71L11.293,12Z">
                                    </path>
                                    <path
                                        d="M12,21.933A9.933,9.933,0,1,1,21.934,12,9.945,9.945,0,0,1,12,21.933ZM12,3.067A8.933,8.933,0,1,0,20.934,12,8.944,8.944,0,0,0,12,3.067Z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="position-absolute image-hover w-100 h-100 top-0 start-0" v-else>
                <img style="z-index: 1;" class="position-absolute top-0 start-0 w-100 h-100"
                    :src="isDefaultImage ? image : generateURL(files[0])" alt="preview image" />
                <div style="z-index: 2; background-color: rgba(0, 0, 0, 0.365);"
                    class="position-absolute top-0 start-0 close-container w-100 h-100">
                    <button type="button" @click="removeImage(files[0])"
                        class="border-0 outline-0 d-flex align-items-center justify-content-center w-50px h-50px bg-transparent text-danger">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="40px"
                            width="40px" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path
                                        d="M9.525,13.765a.5.5,0,0,0,.71.71c.59-.59,1.175-1.18,1.765-1.76l1.765,1.76a.5.5,0,0,0,.71-.71c-.59-.58-1.18-1.175-1.76-1.765.41-.42.82-.825,1.23-1.235.18-.18.35-.36.53-.53a.5.5,0,0,0-.71-.71L12,11.293,10.235,9.525a.5.5,0,0,0-.71.71L11.293,12Z">
                                    </path>
                                    <path
                                        d="M12,21.933A9.933,9.933,0,1,1,21.934,12,9.945,9.945,0,0,1,12,21.933ZM12,3.067A8.933,8.933,0,1,0,20.934,12,8.944,8.944,0,0,0,12,3.067Z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: ["image", "multiple", "isUploading"],
    emits: ["change"],
    data() {
        return {
            isDragging: false,
            isDefaultImage: false,
            files: [],
        };
    },
    methods: {
        onChange() {
            this.files.push(...this.$refs.file.files);
            this.$emit("change", this.$refs.file.files)
        },
        dragover(e) {
            e.preventDefault();
            this.isDragging = true;
        },
        dragleave() {
            this.isDragging = false;
        },
        drop(e) {
            e.preventDefault();
            this.$refs.file.files = e.dataTransfer.files;
            this.onChange();
            this.isDragging = false;
        },
        generateURL(file) {
            let fileSrc = URL.createObjectURL(file);
            setTimeout(() => {
                URL.revokeObjectURL(fileSrc);
            }, 1000);
            return fileSrc;
        },
        removeImage(file) {
            this.files = this.files.filter(f => f !== file);
        },
        removeDefaultImage() {
            this.isDefaultImage = false;
        }
    },
    created() {
        if (this.image) this.isDefaultImage = true;
    }
});
</script>
