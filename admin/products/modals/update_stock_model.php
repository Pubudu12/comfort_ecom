
<div class="modal fade" id="price_edit_modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg stock_modal">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Update Product Stocks</h4>
            </div>

            <div class="modal-body">
                    
                <div class="col-12 add_more_stock_sec">
                    <h5>Add Stock</h5>
                        
                    <form class="forms-sample" id="create_product_price_stock_form"
                        data-action-after=3
                        data-redirect-url="updateStockTableCall"
                        method="POST"
                        action="<?php echo URL ?>products/ajax/controller/createProductController.php">
                        <div class="row">
                            <div class="col-xs-12 col-lg-6">
                                <select name="warehouse" class="select2" style="width: 100%">
                                    <?php 
                                    $select_warehouse = mysqli_query($localhost, "SELECT * FROM `warehouses` WHERE `active`=1 ");
                                    while($fetch_warehouse = mysqli_fetch_array($select_warehouse)){ ?>
                                        <option value="<?php echo $fetch_warehouse['id'] ?>"><?php echo $fetch_warehouse['name'].' - '.$fetch_warehouse['location'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-xs-12 col-lg-6">

                                <input type="hidden" name="add_pro_new_stock" value="0" id="add_new_product_price_id">

                                <div class="input-group">
                                    <input type="number" name="qty" class="form-control" placeholder="Enter the qty">
                                    <span class="input-group-btn">
                                        <button class="btn btn-slide-line center btn-blue submit_form_no_confirm" data-notify_type=2 data-validate=0 type="button"><span class="fa fa-check" aria-hidden="true"> </span> Add</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

                <div class="col-lg-12">
                    <h5>Stock Details</h5>
                    <table class="table table-condensed table-striped table-hover" id="modal_stock_details_table">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>Qty</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="modal_stock_details_table_tbody">
                            <tr>
                                <td class="table_warehouse_name">Main Store</td>
                                <td>                                    
                                    <form class="forms-sample"
                                        data-action-after=3
                                        data-redirect-url="updateStockTableCall"
                                        method="POST"
                                        action="<?php echo URL ?>products/ajax/controller/updateProductController.php">

                                        <div class="input-group product_single_qty_group_form">

                                            <input type="number" class="form-control product_single_qty_form" name="qty" placeholder="Enter the qty">
                                            <span class="input-group-btn">
                                                <button class="btn btn-slide-line center btn-blue submit_form_no_confirm" data-notify_type=2 data-validate=0 type="button" ><span class="fa fa-check" aria-hidden="true"> </span> Update</button>
                                            </span>
                                            <input type="hidden" name="update_stock_id" class="updateStockTableCall product_single_btn_update_form">
                                        </div>
                                    </form>
                                </td>

                                <td class="text-center"> 
                                    
                                    <button  class="btn btn-slide-line center btn-red product_single_btn_delete_form btn-danger fa fa-trash-o"
                                            onclick="deleteItem(this)"
                                            data-after-success=3
                                            data-id="" 
                                            data-refresh='updateStockTableCall' 
                                            data-url="<?php echo URL ?>products/ajax/controller/deleteProductController.php" 
                                            data-key="delete_price_stock"></button>
                                </td>
                            </tr>    
                        </tbody>

                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-slide-line center btn-silver" data-dismiss="modal" onclick="productPriceListDatatable()">Close</button>
            </div>
        </div>
    </div>

</div>

<input type="hidden" onclick="displayPriceStockDetails()" id="updateStockTableCall">