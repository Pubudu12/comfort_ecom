
<?php
//if($total_num_products > 0){ ?>
<hr>    
<!-- <div class="paginatoin-area">
    <div class="row"> -->
        <!-- <div class="col-lg-6 col-md-6">
            <p>Showing <?php //echo $limit_start+1 ?>–<?php //echo ($limit_start)+$per_page ?> of <?php //echo $total_num_products ?> results</p>
        </div>
        <div class="col-lg-6 col-md-6">
            <ul class="pagination-box">
                <li><a href="#" class="Previous change_page_no" data-value="<?php //echo ($page-1) ?>"><i class="fa fa-chevron-left"></i> Previous</a> </li>

                <?php 
                    //for($i = 1; $i <= $total_pages; $i++){ ?>

                        <li class="<?php //echo doactive($i,$page) ?>" ><a href="#" class="change_page_no" data-value="<?php //echo $i ?>"> 7<?php //echo $i ?> </a></li>
                <?php 
                    //} ?>

                <li>
                    <a href="#" class="Next change_page_no"  data-value="<?php //echo ($page+1) ?>"> Next <i class="fa fa-chevron-right"></i></a>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-6">
                <p class="result-count">Showing <?php echo $paginationArray['showingProductsStart'].'-'.$paginationArray['showingProductsEnd'].' of '.$paginationArray['totalRows'] ?> </p>
            </div>

            <div class="col-md-6">
                <ul class="prev-next-btns">
                    <li><a href="#" class="Previous change_page_no" data-value="<?php echo ($paginationArray['currentpage']-1) ?>"><i class="fa fa-chevron-left"></i> Previous</a> </li>
                    <li>
                        <?php //for ($i=1; $i <= $paginationArray['totalPages']; $i++) { ?>
                            <!-- <a class="ml-2 mr-2 <?php //echo doactive($i,$page) ?>" href="<?php echo URL."shop/".'&page='.$i ?>" data-value="<?php echo $i ?>"><?php echo $i ?></a> -->
                        <?php //} ?>
                    </li>
                    <li class=" <?php echo doactive($page,$page) ?>"><a class="page-link change_page_no" data-value="<?php echo $page ?>" href="#"><?php echo $page ?></a></li>
                    <li>
                        <a href="#" class="Next change_page_no"  data-value="<?php echo ($paginationArray['currentpage']+1) ?>"> Next <i class="fa fa-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    <!-- </div>
</div> -->
<hr>
<?php //} ?>

