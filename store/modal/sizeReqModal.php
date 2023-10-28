<div class="header-login-register-wrapper modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-box-wrapper">
                <div class="helendo-tabs">
                    <!-- <ul class="nav" role="tablist">
                        <li class="tab__item nav-item active">
                            <a class="nav-link active" data-toggle="tab" href="#tab_list_06" role="tab">Login</a>
                        </li>
                        <li class="tab__item nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_list_07" role="tab">Our Register</a>
                        </li>

                    </ul> -->
                </div>
                <div class="tab-content content-modal-box">
                    <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                            id="size-request-form"
                            action="<?php echo URL ?>app/controllers/enqireMailController.php">
                        <div class="billing-info-wrap mr-100">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label> Name </label>
                                        <input type="text" id="billing-form-name" name="name"  placeholder="Name" >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label> Email </label>
                                        <input type="text" id="billing-form-name" name="email"  placeholder="Email" >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label> Contact No </label>
                                        <input type="text" id="billing-form-cont" name="contact_no"  placeholder="Contact No" >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label> Custom Size </label>
                                        <div class="col-12">
                                            <div class="row">
                                                <input class="col-4" type="text" id="billing-form-name" name="custom_width"  placeholder="Width" >
                                                <input class="col-4" type="text" id="billing-form-name" name="custom_height"  placeholder="Height" >
                                                <input class="col-4" type="text" id="billing-form-name" name="custom_length"  placeholder="Length" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="additional-info-wrap">
                                        <label>Message</label>
                                        <textarea placeholder="Notes about your customized size" name="message" id="shipping-form-memo" name="shipping-form-memo"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="place-order mt-30">  
                            <input type="hidden" value="<?php echo $productId?>" name="rquest_custom_size">
                            <button class="btn btn--full btn--brown btn--lg text-center submit_form_no_confirm" data-notify_type=2 data-validate=1 type="button">Request</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>