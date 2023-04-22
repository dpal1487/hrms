<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { required } from "@vuelidate/validators";
import ComponyAside from "../../Components/Company/CompanyAside.vue"
import CompanyStepFirst from "../../Components/Company/CompanyStepFirst.vue";
import CompanysecondStepVue from "../../Components/Company/CompanysecondStep.vue";
import CompanyThirdStep from "../../Components/Company/CompanyThirdStep.vue";
import CompanyFourthStep from "../../Components/Company/CompanyFourthStep.vue";
import CompanyFifthStep from "../../Components/Company/CompanyFifthStep.vue";

export default defineComponent({
    props: [''],
    setup() {
    },
    validations() {
        return {

        };
    },
    data() {
        return {
            currStep: 0,
            form: this.$inertia.form({
                company_type: 'personal',
                account_team_size: '2-10',
                tax_number: '',
                company_domain:'',
                company_website:'',
                account_plan: 'Developer Account' ,
                company_number:'+911111111111',
                company_email:'corp@support.com',
                sorted_description:'KEENTHEMES',
                corporate_type:'',
                description:'',
                company_name:'Keenthemes Inc.',
                card_name:'Max Doe',
                card_number:'4111 1111 1111 1111',
                card_expiry_month:'',
                card_expiry_year:'',
                card_cvv:'',
                card_save:'1',

            })
        };
    },
    components: {
        AppLayout,
        ComponyAside,
        CompanyStepFirst,
        CompanysecondStepVue,
        CompanyThirdStep,
        CompanyFourthStep,
        CompanyFifthStep,
        Link,

    },
    methods: {
        submit() {
            console.log("see this value", this.form);
            this.form
                .transform((data) => ({
                    ...data,
                }))
                .post(this.route('company.store'), this.form.id)
            //    }
        },
        onPrev() {
            if (this.currStep > 0) this.currStep--;
        },
        handleFinalClick() {
            if (this.currStep === 4) {
                // this.submit();
            } else {
                if (this.currStep < 5 && this.currStep >= 0) this.currStep++;
            }
        }
    },
    created() {

    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Company' : `Add New Company`" />



    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Multi-steps-->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid stepper stepper-pills stepper-column stepper-multistep"
            id="kt_create_account_stepper">
            <!--begin::Aside-->
            <ComponyAside :currStep="currStep" />
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-650px w-xl-700px p-10 p-lg-15 mx-auto">
                        <!--begin::Form-->
                        <form @submit.prevent="submit()" class="my-auto pb-5">
                            <!--begin::Step 1-->
                            <CompanyStepFirst :form="form" v-if="currStep === 0" @next="onNext" />
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <CompanysecondStepVue :form="form" v-if="currStep === 1" @next="onNext" />
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <CompanyThirdStep :form="form" v-if="currStep === 2" @next="onNext" />

                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <CompanyFourthStep :form="form" v-if="currStep === 3" @next="onNext" />

                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <CompanyFifthStep :form="form" v-if="currStep === 4" @next="onNext" />

                            <!--end::Step 5-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack pt-15">
                                <div class="mr-2">
                                    <button @click="onPrev" type="button" v-if="currStep > 0"
                                        class="btn btn-lg btn-light-primary me-3">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1"
                                                    fill="currentColor" />
                                                <path
                                                    d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Previous</button>
                                    <Link v-if="currStep === 0" href="/company"
                                        class="btn btn-secondary align-items-center justify-content-center">
                                    Cancel
                                    </Link>
                                </div>
                                <div>
                                    <!-- {{ currStep }} -->
                                    <button :type="currStep === 4 ? 'submit' : 'button'" @click="handleFinalClick"
                                        class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                        <span v-if="currStep === 3">Submit</span>
                                        <span v-else>Continue</span>
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                        <span class="svg-icon svg-icon-4 ms-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor" />
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></button>
                                </div>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Multi-steps-->
    </div>
</template>
