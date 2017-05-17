<?php 
$cart = new Checkoutsession();
$cartData = $cart->getCartData();
?>
<table>
    <tbody>
        <tr>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        <?php foreach($cartData as $_cart){?>
            <tr>
                <td><?php echo $_cart['post_title']?></td>
                <td><?php echo $_cart['cart_qty']?></td>
                <td><?php echo number_format($_cart['price'],2)?></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td>
                <input type="submit" name="checkout" value="checkout" id="checkout-button"/>
            </td>
        </tr>
    </tbody>
</table>
    

		
