<!-- Monthly Activities -->
<div class="col-12">
    <div class="card order-graph">
        <div class="card-header">
            <h3 class="sub_title">Monthly Analytics <small> <?php echo Date("F") ?> </small> </h3>
        </div>

        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#orders_month_tab">Orders & Signups</a></li>
            <li class="nav-item "><a class="nav-link" data-toggle="tab" href="#income_month_tab"> Earnings </a></li>
            <li class="nav-item "><a class="nav-link" data-toggle="tab" href="#products_month_tab"> Products </a></li>
        </ul>

        <div class="tab-content">
            
            <div id="orders_month_tab" class="tab-pane container active">
                
                <canvas id="month-order_chart"></canvas>
                
            </div>

            <div id="income_month_tab" class="tab-pane container">
                
                <canvas id="month-amount_chart"></canvas>

            </div>

            <div id="products_month_tab" class="tab-pane container">
                
                <canvas id="month-product_chart" height="140px"></canvas>

            </div>

        </div>
    </div>

</div>