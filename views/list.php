<?php 

$uri = $args['url'];
$allProducts = $args['products'];

?>
<table>
    <?php foreach($allProducts as $eachProduct){?>
    <tr>
        <td>Title:</td>
        <td><?php echo $eachProduct->post_title?></td>
    </tr>
    <tr>
        <td>Description:</td>
        <td><?php echo $eachProduct->post_content?></td>
    </tr>
    <tr>
        <td>Qty:</td>
        <td><?php echo $eachProduct->qty?></td>
    </tr>
    <tr>
        <td>Price:</td>
        <td>Rs. <?php echo ($eachProduct->price) ? number_format($eachProduct->price , 2) : '';?></td>
    </tr>
    <tr>
        <td>View:</td>
        <td> <a href='#'>link</a></td>
    </tr>
    <tr>
        <td></td>
        <td> <div class="add-to-cart" productid="<?php echo $eachProduct->ID?>" url="<?php echo $uri?>">Add to Cart</div></td>
    </tr>
    <tr>
        <td></td>
        <td> <div class="remove-from-cart" productid="<?php echo $eachProduct->ID?>" url="<?php echo $uri?>">Remove From Cart</div></td>
    </tr>
    </table>
    <table>
    <?php }?>
</table>
