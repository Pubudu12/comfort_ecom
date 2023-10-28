  <!-- Page Sidebar Start-->
  <div class="page-sidebar">
            <div class="main-header-left d-none d-lg-block">
                <div class="logo-wrapper"><a href="<?php echo URL?>home"><img class="blur-up lazyloaded" src="<?php echo URL?>assets/images/comfortWorld.png"  style="width: 100%; height: auto" alt=""></a></div>
            </div>
            <div class="sidebar custom-scrollbar">
                <div class="sidebar-user text-center">
                    <!-- <div><img class="img-60 rounded-circle" src="" alt="#">
                    </div> -->
                    <h6 class="mt-3 f-14"><?php echo ADMIN_USERNAME ?></h6>
                </div>
                <ul class="sidebar-menu">
                    
                    <li><a class="sidebar-header" href="<?php echo URL?>home"><i data-feather="home"></i><span>Dashboard</span></a></li>
                    
                    <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>Categories</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>category"><i class="fa fa-circle"></i>Category</a></li>
                        </ul>
                    </li>

                    <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>Products</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>products"><i class="fa fa-circle"></i>Product List</a></li>
                            <li><a href="<?php echo URL?>sizes"><i class="fa fa-circle"></i>Size List</a></li>
                            <li><a href="<?php echo URL?>sizeCategories/sizeList.php"><i class="fa fa-circle"></i>Size Category List</a></li>
                            <li><a href="<?php echo URL?>sizesRequests"><i class="fa fa-circle"></i>Size Requests</a></li>
                            <li><a href="<?php echo URL?>products/create_product.php"><i class="fa fa-circle"></i>Add Product</a></li>
                        </ul>
                    </li>

                    <li><a class="sidebar-header" href=""><i data-feather="dollar-sign"></i><span>Orders</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>orders/orders.php"><i class="fa fa-circle"></i>Order List</a></li>
                        </ul>
                    </li>
                    
                    <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>PromoCodes</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>promo_codes"><i class="fa fa-circle"></i>PromoCodes</a></li>
                        </ul>
                    </li>

                    <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>Serial Numbers</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>serialNumbers"><i class="fa fa-circle"></i>Serial Numbers List</a></li>
                            <li><a href="<?php echo URL?>serial/upload"><i class="fa fa-circle"></i>Upload Serial Numbers</a></li>
                        </ul>
                    </li>

                    <?php 
                    $selectMenuRef = mysqli_query($localhost, "SELECT * FROM `references_master_list` WHERE `dimension` = '1d' ");
                    if(mysqli_num_rows($selectMenuRef) > 0){ ?>

                        <!-- <li><a class="sidebar-header" href="#"><i data-feather="bookmark"></i> <span>Brands</span><i class="fa fa-angle-right pull-right"></i></a>
                            <ul class="sidebar-submenu">

                                    <?php
                                    while($fetchMenuRef = mysqli_fetch_array($selectMenuRef)){
                                        ?>
                                        
                                            <li><a href="<?php echo URL?>ref/1d?id=<?php echo $fetchMenuRef['id'] ?>&c=<?php echo $fetchMenuRef['code'] ?>"><i class="fa fa-circle"></i>Brand List</a></li>

                                        <?php
                                    }
                                    ?>
                            </ul>
                        </li> -->
                    <?php
                    }
                    ?>

                    <li><a class="sidebar-header" href="#"><i data-feather="book"></i> <span>Posts</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>blog/category"><i class="fa fa-circle"></i>Post Category </a></li>
                            <li><a href="<?php echo URL?>blog/category/create"><i class="fa fa-circle"></i>Create Post Category </a></li>
                            <li><a href="<?php echo URL?>blog/post"><i class="fa fa-circle"></i>Post</a></li>
                            <li><a href="<?php echo URL?>blog/post/create"><i class="fa fa-circle"></i>Create Post</a></li>
                        </ul>
                    </li>

                    <li><a class="sidebar-header" href="#"><i data-feather="image"></i> <span>Gallery</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>gallery/categories"><i class="fa fa-circle"></i>Gallery Categories </a></li>
                            <li><a href="<?php echo URL?>galleryItems"><i class="fa fa-circle"></i>Gallery </a></li>
                            <li><a href="<?php echo URL?>gallery/create"><i class="fa fa-circle"></i>Create Gallery</a></li>
                        </ul>
                    </li>

                    <!-- <li><a class="sidebar-header" href="#"><i data-feather="bookmark"></i> <span>Blogs</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>blog/category"><i class="fa fa-circle"></i>Post Category </a></li>
                            <li><a href="<?php echo URL?>blog/category/create"><i class="fa fa-circle"></i>Create Post Category </a></li>
                            <li><a href="<?php echo URL?>blog/post"><i class="fa fa-circle"></i>Post</a></li>
                            <li><a href="<?php echo URL?>blog/post/create"><i class="fa fa-circle"></i>Create Post</a></li>
                        </ul>
                    </li> -->

                    <li><a class="sidebar-header" href="<?php echo URL?>customer/customers.php"><i data-feather="user-plus"></i><span>Customers</span></a> </li>

                    <!-- <li><a class="sidebar-header" href="<?php echo URL?>downloads/file"><i data-feather="download"></i><span>Downloads</span></a> </li> -->

                    <li><a class="sidebar-header" href=""><i data-feather="users"></i><span>Dealers</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>dealer/dealers.php"><i class="fa fa-circle"></i>Dealer List</a></li>
                            <li><a href="<?php echo URL?>dealer/create.php"><i class="fa fa-circle"></i>Create Dealer</a></li>
                        </ul>
                    </li>

                    <li><a class="sidebar-header" href=""><i data-feather="users"></i><span>Users</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo URL?>admin/users.php"><i class="fa fa-circle"></i>User List</a></li>
                            <!-- <li><a href="<?php echo URL?>admin/userActions.php"><i class="fa fa-circle"></i>User Actions</a></li> -->
                            <li><a href="<?php echo URL?>admin/create-user.php"><i class="fa fa-circle"></i>Create User</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
        <!-- Page Sidebar Ends-->