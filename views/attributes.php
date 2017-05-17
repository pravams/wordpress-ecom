<!-- use for nonce verification -->
<input type="hidden" name="pravams_product_attr_nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>" />
<?php 
global $wpdb;
global $post;
 
$table_name = $wpdb->prefix . 'pravams_products';

$sql = "Select * from $table_name where product_id = $post->ID";

$list = $wpdb->get_results($sql);

if(!empty($list)){
    $price = $list[0]->price;
    $qty = $list[0]->qty;
}else{
    $price = "";
    $qty = "";
}
$price = number_format($price,2);
?>
<table class="form-table">
    <tbody>
        <tr>
            <th><label for="Quantity">Quantity</label></th>
            <td><input type="text" name="pravams_product_qty" value="<?php echo $qty;?>" id="pravams_product_qty"/></td>
        </tr>
        <tr>
            <th><label for="Price">Price</label></th>
            <td><input type="text" name="pravams_product_price" value="<?php echo $price;?>" id="pravams_product_price"/></td>
        </tr>
    </tbody>
</table>