<script>
import { defineComponent } from 'vue';

import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: { Link }
})
</script>
<template>
    <body bgcolor="#d7d7d7" class="generic-template"
        style="-moz-osx-font-smoothing: grayscale; -webkit-font-smoothing: antialiased; background-color: #d7d7d7; margin: 0; padding: 0;">
        <!-- Content Start -->
        <table cellpadding="0" cellspacing="0" cols="1" bgcolor="#d7d7d7" align="center" style="max-width: 600px;">
            <tr>
                <td height="150"
                    style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                </td>
            </tr>

            <!-- This encapsulation is required to ensure correct rendering on Windows 10 Mail app. -->
            <tr>
                <td>
                    <!-- Generic Pod Left Aligned with Price breakdown Start -->
                    <table class="bordered-left-right bg-white" >
                        <tr height="50">
                           
                        </tr>
                        <tr align="center">
                            <td>
                            </td>
                            <td>
                                <img src="http://dgtlmrktng.s3.amazonaws.com/go/emails/generic-email-template/tick.png"
                                    alt="GO" width="50">
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr height="17">
                            <td>
                            </td>
                        </tr>
                        <tr align="center">
                            <td>
                            </td>
                            <td>
                                <h1
                                    style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 30px; font-weight: 700; line-height: 34px; margin-bottom: 0; margin-top: 0;">
                                    Payment received</h1>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr height="30">
                            <td>
                            </td>
                        </tr>
                        <tr align="left">
                            <td>
                            </td>
                            <td>
                                    Hi [name],
                            </td>
                            <td>
                            </td>
                        </tr>
                       
                        <tr align="left">
                            <td >
                            </td>
                            <td>
                                <p>
                                    Your transaction was successful!</p>
                                <br>
                                <p
                                    style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0; ">
                                    <strong>Payment Details:</strong><br />

                                    Amount: €$moneyFormatter.format(${amount}) <br />
                                    Account: ${accountNumber}.<br />
                                </p>
                                <br>
                                <p>
                                    We advise to keep this email for future reference.&nbsp;&nbsp;&nbsp;&nbsp;<br /></p>
                            </td>
                            <td>
                            </td>
                        </tr>
                       
                        <tr align="center">
                            <td width="36"
                                style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                            </td>
                            <td
                                style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                <p>
                                    <strong>Transaction reference: ${authorizationCode}</strong>
                                </p>
                                <p>
                                    Order date: [time] [date]</p>
                                <p>
                                </p>
                            </td>
                            <td width="36"
                                style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                            </td>
                        </tr>

                        <tr height="50">
                            <td colspan="3">
                                <Link :href="'/plan'" class="m-10">
                                Back To Dashbord
                                </Link>
                            </td>
                        </tr>

                    </table>
                    <!-- Generic Pod Left Aligned with Price breakdown End -->
                </td>
            </tr>
        </table>


        <!-- Content End -->

    </body>
</template>