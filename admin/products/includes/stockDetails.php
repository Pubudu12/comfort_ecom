<div class="row product-page-main card-body">
    <div class="jumbotron product-tbl-width">
        <div class="table-responsive col-xl-12">
            <h2 class="stock-detail-h2">Stock & Price</h2>

            <table class="dataTableCall" 
                id="products_stock_list-table" 
                data-url = '<?php echo URL ?>products/ajax/stock_list.php'
                onchange="productStockListDatatable()">
                        <thead>
                            <tr class="text-center">
                                <th>Size</th>
                                <th>Actual Price</th>
                                <th>Discount</th>
                                <th>Sale Price</th>
                                <th>Dealer Price</th>
                                <!-- <th>Stock</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                <hr>
            </div>

            <div class="col-md-12">
                <form class="forms-sample" id="create_product_price_form"
                    data-action-after=2
                    data-redirect-url="<?php echo URL?>products/view_product.php?id=<?php echo $product_id ?>"
                    method="POST"
                    action="<?php echo URL ?>products/ajax/controller/createProductController.php">

                        <div class="row">
                            <div class="form-group col-7">
                                <label class="text-bold">Product Size</label>
                                <select class="form-control select2"  name="sizes[]" multiple>
                                    <?php foreach ($sizeArray as $key => $value) { ?>
                                        <option value="<?php echo $value['id']?>"><?php echo $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-5">
                                <label class="text-bold">Actual Price</label>
                                <input type="text" name="pro_actual_price" id="actual_price" class="form-control text-right" placeholder="Actual Price" onkeyup="calculateProductPrice()">
                            </div>

                            <div class="form-group col-4">
                                <label class="text-bold">Discount</label>
                                <span class="input-group ">
                                    <select id="price_dis_type" name="pro_price_dis_type" class=" custom-select" data-live-search="true" onkeyup="calculateProductPrice()">
                                        <option value="%">%</option>
                                        <option value="/" class="hide">/</option>
                                    </select>
                                    <input type="text" class=" form-control text-right" value=0 name="pro_discount_value" id="discount_value" placeholder="Discount" onkeyup="calculateProductPrice()">
                                </span>
                            </div>

                            <div class="form-group col-3">
                                <label class="text-bold">Dealer Price</label>
                                <input type="text" name="pro_dealer_price" id="dealer_price" class="form-control text-right" placeholder="Dealer Price" onkeyup="calculateProductPrice()">
                            </div>

                            <div class="form-group col-4">
                                <label class="text-bold">Sale Price</label>
                                <input type="text" readonly name="pro_sale_price"  class="form-control text-right" id="pro_sale_price" placeholder="Sale Price">
                            </div>

                            <div class="form-group col-1 margin-top text-right">
                                <input type="hidden" name="create_product_price" value="<?php echo $product_id ?>">
                                <button type="button" class="btn btn-primary pull-right submit_form_no_confirm" data-notify_type=2 data-validate=0  ><i class="fa fa-plus"></i> </button>
                            </div>

                        </div>

                </form>
            </div>
        </div>
</div>


<?php 
    include_once ROOT_PATH.'products/modals/price_updates_modal.php';
    include_once ROOT_PATH.'products/modals/update_stock_model.php';
?>

<input type="hidden" id="clickStockDataTable" onclick="productPriceListDatatable()">