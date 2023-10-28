<div class="product-pagination">
    <div class="theme-paggination-block">
        <div class="row">
            
            <div class="col-xl-6 col-md-6 col-sm-12">

                <nav aria-label="Page navigation">
                    
                    <ul class="pagination">

                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous" data-value="<?php echo ($page-1) ?>">
                                <span aria-hidden="true"> <i class="fa fa-chevron-left" aria-hidden="true"></i></span> 
                                <span class="sr-only">Previous</span>
                                </a>
                            </li>

                        <?php
                        
                        
                        for ($no=1; $no <= $totalPages; $no++) {  ?><!--<?php //echo doactive($currentpage, $no) ?>-->
                            <li class="page-item"><a class="page-link" href="#"><?php echo $no;  ?></a></li>
                        <?php } ?>
                        

                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next" data-value="<?php echo ($page-1) ?>">
                                <span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <div class="col-xl-6 col-md-6 col-sm-12">
                <div class="product-search-count-bottom">
                    <h5>Showing Products <?php echo $paginationArray['showingProductsStart'].'-'.$paginationArray['showingProductsEnd'].' of '.$paginationArray['totalRows'] ?>  Result</h5>
                </div>
            </div>

        </div>
    </div>
</div>