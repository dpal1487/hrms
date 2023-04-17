<script>
import { defineComponent } from 'vue';


export default defineComponent({
    props: ["email", "selectedImage", "errors"],
    data() {
        return {
            isEdit: false,
        }
    },
    components: {
    },
    methods: {
        showEditEmail() {
            this.isEdit = true;
        },
        hideEditEmail() {
            this.isEdit = false;
        }
    }
})
</script>


<template>
    <div v-if="isEdit" class="flex-row-fluid">
        <!--begin::Form-->
        <form class="form" novalidate="novalidate">
            <div class="row mb-6">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="fv-row mb-0">
                        <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New
                            Email Address</label>
                        <input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress"
                            placeholder="Email Address" name="emailaddress" value="support@keenthemes.com" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="fv-row mb-0">
                        <label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
                        <input type="password" class="form-control form-control-lg form-control-solid"
                            name="confirmemailpassword" id="confirmemailpassword" />
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-primary me-2 px-6">Update
                    Email</button>
                <button type="button" @click="hideEditEmail"
                    class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <div v-else class="d-flex flex-wrap align-items-center">
        <div>
            <div class="fs-6 fw-bold mb-1">Email Address</div>
            <div class="fw-semibold text-gray-600">{{ email }}</div>
        </div>
        <!--end::Label-->
        <!--begin::Edit-->

        <!--end::Edit-->
        <!--begin::Action-->
        <div class="ms-auto">
            <button type="button" @click="showEditEmail" class="btn btn-light btn-active-light-primary">Change
                Email</button>
        </div>
        <!--end::Action-->
    </div>
</template>
