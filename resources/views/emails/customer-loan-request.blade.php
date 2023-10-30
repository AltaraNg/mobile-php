@include('emails.header')


<div style="background-color:transparent;">
    <div class="block-grid "
        style="Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
            <div class="col num12"
                style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;">
                <div style="width:100% !important;">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div
                        style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                        <!--<![endif]-->

                        <div class="button-container" align="left"
                            style="padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">

                            <h5>Hello, {{ $customer_name ?? 'there' }}</h5>
                            <p>
                                Thank you for choosing Altara Credit for your loan application. We have received your
                                request and are in the process of reviewing your application.
                            </p>

                            <div class="customer">
                                <h3>Loan Request Information</h3>
                                <p><b>Loan Amount: </b> {{ $product_price ?? 0 }}</p>
                                <p><b>Application ID: </b> {{ $application_id ?? "N/A" }}</p>
                                <p><b>Request Date: </b> {{ $request_date ?? 1000 }}</p>
                            </div>
                            <p>
                                Please note that our team will carefully evaluate your application to ensure the
                                best possible outcome. You can expect further communication from us soon.
                            </p>
                        </div>

                        <div
                            style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:2px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                            <div
                                style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
                                <p
                                    style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;">
                                    If you have any questions or need assistance, please feel free to contact our
                                    support team at {{config('app.credit_checker_mail')}}
                                </p>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@include('emails.footer')
