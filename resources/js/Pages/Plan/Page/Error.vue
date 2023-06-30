
<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import PaymentForm from "../Components/Model/PaymentForm.vue";


export default defineComponent({

    props: ["plan", "message"],
    emits: ['onhide'],
    data() {
        return {
            isModalOpen: false,

        }
    },
    components: {
        PaymentForm,
        Link
    },
    methods: {
        showCreateTicketModal() {
            this.isModalOpen = true;
        },
        hideCreateTicketModal() {
            this.isModalOpen = false;
        },
    }
})
</script>
<template>
    <div class="d-flex flex-column flex-root generic-template" bgcolor="#d7d7d7"
        style="-moz-osx-font-smoothing: grayscale; -webkit-font-smoothing: antialiased; background-color: #d7d7d7; margin: 0; padding: 0;">
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-lg-450px py-5">
                    <div class="card-body py-15 py-lg-20">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="p-30px text-gray-700 fs-6 border-radius-9">
                                        <span class="fs-1 text-capitalize"><b>Uh oh, your payment failed </b></span>
                                        <br><br>On {{ date }} your payment of ${{ charge_amount }} for your subscription
                                        <strong>"{{
                                            plan_name }} - {{ domain }}"</strong> was due.
                                        <br><br>We tried to process your payment but had no luck. The system will attempt
                                        the transaction
                                        for the next {retry_days} days.
                                        <br><br>If all transaction attempts failed, all traffic will <strong>be redirected
                                            back to the
                                            origin server</strong> until the payment has been cleared.
                                        <br><br>We suggest you review your billing information and make changes if
                                        necessary.

                                        <br><br><br><br>

                                        <PaymentForm :show="isModalOpen" @hidemodal="hideCreateTicketModal"
                                            :plan="plan?.data" />
                                        <button type="submit" @click="showCreateTicketModal"
                                            class="btn btn-light-primary">UPDATE
                                            PAYMENT METHOD</button>
                                        <br><br>
                                        <center><span style="font-size:12px;">Have any questions? Please write to <a
                                                    href="mailto:support@{{ partner_domain }}"
                                                    style="color:#81CDFF;">support@{{
                                                        partner_domain }}</a> and we’d be happy to answer them.</span></center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--begin::Title-->
                        <div class="m-5">
                            <Link href="/plan" class="btn btn-sm btn-primary">Return Home</Link>
                        </div>
                        <!--end::Link-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
</template>