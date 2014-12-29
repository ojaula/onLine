<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 12/17/2014
 * Time: 3:26 PM
 */
    require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));
    if(!isset($_SESSION)){
        session_start();
    }

    // is logged in?
    if(isset($_SESSION['sess_user_id']))
    {
        $userCurrentOrder = get_user_currentOrder(0,$_SESSION['sess_user_id']);
        $userCurrentOrderOBJ = new SimpleXMLElement($userCurrentOrder);
        $order = $userCurrentOrderOBJ->order;
        $orderId = $order->order_id;

        $userOrderDetails = get_order_orderDetails(0, $orderId);
        $userOrderDetailsOBJ = new SimpleXMLElement($userOrderDetails);
        $orderDetais = $userCurrentOrderOBJ->orderDetails->order_id;

        echo "Your order is not yet verified. Please check
          that all information is correct and then confirm your order.
           If you pay by internet banking or card you will be forwarded.";

        echo'<div class="summary"">';
        echo '<div style="width:100%; border:1px #dcdcdc solid;border-radius:5px;">';
        echo "<table class='table'>";
        $totalPris =0;
        foreach($userOrderDetailsOBJ as $orderDetail)
        {
            $price = $orderDetail->orderDetails_quantity * $orderDetail->orderDetails_price;
            $totalPris+=$price;
            echo "<tr>
                      <td style='min-width:450px'>Title: ".$orderDetail->orderDetails_name."</td>
                      <td style='min-width:110px'>Quantity: ".$orderDetail->orderDetails_quantity."</td>
                      <td>Price: ".$price."</td>
                      </tr>";
        }
        echo "</table></div>";

    }
    // print sum/price of order
    echo '      <div style="width:100%; border:1px #dcdcdc solid;border-radius:5px;">
                    <div style="float:right;">
                        <span  class="total_text">Total:</span> <span class="total"><span id="total_sum">'.$totalPris.'</span> kr</span>
                        <br>
                        <span class="breakdown" id="breakdown_text">With Shipping ('.$totalPris.' + 0 kr)</span>
                    </div>
                </div>';

    //print customer/order details
    $odetail =
        '<table style="width:100%; border:1px #dcdcdc solid;border-radius:5px; padding:10px;">'.
            '<tr><td style="min-width: 200px">ShipName:</td><td>'.(string)$order->order_ShipName.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Address</td><td>   '.(string)$order->user->order_ShipAddress.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Email</td><td>            ' .(string)$order->order_email.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">PostAddress</td><td>      '.(string)$order->order_shipZip.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Stad</td><td>             '.(string)$order->order_shipCity.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Land</td><td>             '.(string)$order->order_shipCountry.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Transport</td><td>        '.(string)$order->order_shipping.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Telefon</td><td>          '.(string)$order->order_phone.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Datum</td><td>            '.(string)$order->user_id.'</p><td><tr>'.
            '<tr><td style="min-width: 200px">Order nr</td><td>         '.(string)$order->order_id.'</p><td><tr>'
        .'</table>';
   echo $odetail;

    //Print agreement
    echo '<div class="cartconfirmation" style="border:1px #dcdcdc solid;border-radius:5px;">
			<tr><td style="max-width:200px;"><p>
                <label I have read and agree to the Terms and agrees that line will handle my personal data in accordance with the Privacy Act
                </label>
                </p>
            </td>
            <td>
                <button onclick="sendRequest_post(\'action=order_finished\',\'ajaxCallback_order_finished\')" class="button">Complete order</button>
            </td></tr>';

    echo '</div>';
