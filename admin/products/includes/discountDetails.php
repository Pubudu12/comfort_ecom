<div class="row product-page-main card-body">
    <div class="jumbotron product-tbl-width">
        <div class="table-responsive col-xl-12">
            <h2 class="stock-detail-h2">Discounts</h2>

            <table class="dataTableCall" 
                id="products_discountList-table" 
                data-url = '<?php echo URL ?>products/ajax/discount_list.php'
                onchange="productDiscountListDatatable()">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Min Qty</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        
                    </table>
                    
                <hr>
            </div>

            <div class="col-md-12">
            
                <form class="forms-sample" id="create_product_discount_form"
                    data-action-after=3
                    data-redirect-url="clickDiscountDataTable"
                    method="POST"
                    action="<?php echo URL ?>products/ajax/controller/createProductController.php">

                    <div class="row">

                        <div class="form-group col-5">
                            <label class="text-bold">name</label>
                            <input type="text" class="form-control text-right" name="name" placeholder="Name">
                        </div>

                        <div class="form-group col-2">
                            <label class="text-bold">Min Qty</label>
                            <input type="text" name="min_qty"  class="form-control text-right" placeholder="Minimum Qty">
                        </div>

                        <div class="form-group col-4">
                            <label class="text-bold ml-3">Discount</label>
                            <span class="input-group col-12">
                                <select id="price_dis_type" name="discount_type" class="col-md-5 custom-select">
                                    <option value="%">%</option>
                                    <option value="/">/</option>
                                </select>
                                <input type="text" class="col-md-8 form-control text-right" value='0' name="discount_value" placeholder="Discount">
                            </span>
                        </div>

                        <div class="form-group col-1 margin-top text-right">
                            <input type="hidden" name="create_product_discount" value="<?php echo $product_id ?>">
                            <button type="button" class="btn btn-primary pull-right submit_form_no_confirm" data-notify_type=2 data-validate=0  ><i class="fa fa-plus"></i> </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
</div>


<?php 
    include_once ROOT_PATH.'products/modals/updateDiscountModal.php';
?>

<input type="hidden" id="clickDiscountDataTable" onclick="productDiscountListDatatable()">