<div class="slider-area ">
    <div class="single-slider slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>User profile</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Order code</th>
        <th scope="col">Product</th>
        <th scope="col">Date</th>
        <th scope="col">Total pay</th>
    </tr>
    </thead>
    <tbody>
    <?php
    echo"<pre>";
    print_r($orders);
    echo "</pre>";
    foreach ($orders AS $order):?>
    <tr>
        <th scope="row"><?php echo $order['id'];?></th>
        <td><?php echo $order['title'];?></td>
        <td><?php echo $order['created_at'];?></td>
        <td><?php echo number_format($order['price_total']);?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>