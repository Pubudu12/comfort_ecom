<!-- Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verify</h5>

                <div class="margin-left hide" id="verification_status">
                    <i class="verified-icon fa fa-check-circle"></i> 
                    <span class="ml-1">Verified!</span>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="product-adding">
                    <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                    action="<?php echo URL ?>products/ajax/controller/createProductController.php">
                        <div class="row billing-info-wrap">
                            <div class="col-sm-12 col-lg-6">
                                <div class="container-form billing-info">
                                    <div class="form-label-group">
                                        <input type="text"  name="serial_number" id="serial_number" placeholder="Serial Number">
                                        <!-- <label class="col-form-label">Name </label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="container-form">
                                    <div class="form-group form-label-group text-right">
                                        <button class="btn btn--lg btn--black" type="button" onclick="verifySerial()">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>
</div>