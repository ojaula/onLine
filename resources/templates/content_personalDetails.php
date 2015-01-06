<?php
/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 12/15/2014
 * Time: 8:35 PM
 */

//require("/../library/DB_manager.php");
require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));
    if(!isset($_SESSION)){
        session_start();
    }

    $firstName  = (string) "";
    $LastName   = (string) "";
    $Email      = (string) "";
    $address    = (string) "";
    $zip        = (string) "";
    $City       = (string) "";
    $country    = (string) "";
    $phone      = (string) "";
    $order_id   = (string) "";
    $buttonText = (string) "Create Account";
    // is logged in?
    if(isset($_SESSION['sess_user_id'])) {
        $userId = $_SESSION['sess_user_id'];
        $userXml = get_user(0, $userId);
        $userXmlObj = new SimpleXMLElement($userXml);

        $firstName = (string)$userXmlObj->user->user_firstName;
        $LastName = (string)$userXmlObj->user->user_lastName;
        $Email = (string)$userXmlObj->user->user_email;
        $address = (string)$userXmlObj->user->user_address;
        $zip = (string)$userXmlObj->user->user_zip;
        $City = (string)$userXmlObj->user->user_city;
        $country = (string)$userXmlObj->user->user_country;
        $phone = (string)$userXmlObj->user->user_phone;
        $order_id = (string)$userXmlObj->user->user_id;
        $buttonText = (string) "Finished";

    }
echo '
        <h3>Order details</h3>
        <form data-callback="ajaxCallback_updateOrderDetails" data- id="form_insert_order" action="../resources/manage_db.php" method="get">

        <input class="form-control" type="hidden" name="action" value="update_current_order">
        order id:
            <input class="form-control" type="text" name="order_id" value='.$order_id.'>
        shipName:
            <input class="form-control" type="text" name="ship_name" value='.$firstName.$LastName.'>
        shipAddress:
            <input class="form-control" type="text" name="ship_address" value='.$address.'>
        shipName:
            <input class="form-control" type="text" name="ship_zip" value='.$zip.'>
        ship_city:
            <input class="form-control" type="text" name="ship_city" value='.$City.'>
        ship_country:
            <input class="form-control" type="text" name="ship_country" value='.$country.'>
        shipping:
            <input class="form-control" type="text" name="shipping" value="1">
        phone:
            <input class="form-control" type="text" name="phone" value='.$phone.'>
        tax:
            <input class="form-control" type="text" name="tax" value="25%">
        date:
            <input class="form-control" type="hidden" name="date" value='.date('l jS \of F Y h:i:s A').'>
            <input class="form-control" type="hidden" name="paymentId" value="silvercoins by birds">
            <input class="form-control" type="hidden" name="transactStatus" value="pending">
            <input class="form-control" type="hidden" name="shipped" value="0">
            <input class="form-control" type="hidden" name="fullfilled" value="0">
        submit:
            <br>
            <button type="submit">'.$buttonText.'</button>
        </form>
        <script> if (globalAjaxInit == true) {formSubmitEvent_bindAll();} </script>';


?>