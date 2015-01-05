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
$regDate    = date('l jS \of F Y h:i:s A');
$buttonText = (string) "Create Account";
$formAction = (string) "form_insert_user";
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
    $regDate = (string)$userXmlObj->user->user_regDate;
    $formAction = (string) "form_update_user";  // does not exist yet
    $buttonText = (string) "Update Account";

}
echo ' <h3>User Details</h3>
        <form data-callback="ajaxCallback_updateOrderDetails" data- id="form_insert_user" action="../resources/manage_db.php" method="get">

   Action:<br>
        <input class="form-control" type="text" name="action" value="insert_user">
        <br>
        First Name:<br>
        <input class="form-control" type="text" name="firstName" value="'.$firstName.'">
        <br>
        Last Name:
        <br>
        <input class="form-control" type="text" name="lastName" value="'.$LastName.'">
        <br>
        password:
        <br>
        <input class="form-control" type="text" name="password" value="'.$LastName.'">
        <br>
        email DOUBLES AS YOUR LOGIN:
        <br>
        <input class="form-control" type="text" name="email" value="'.$Email.'">
        <br>
        phone:
        <br>
        <input class="form-control" type="text" name="phone" value="'.$phone.'">
        <br>
        address:
        <br>
        <input class="form-control" type="text" name="address" value="'.$address.'">
        <br>
        zip:
        <br>
        <input class="form-control" type="text" name="zip" value="'.$LastName.'">
        <br>
        city:
        <br>
        <input class="form-control" type="text" name="city" value="'.$zip.'">
        <br>
        verificationCode:
        <br>
        <input class="form-control" type="text" name="verificationCode" value="'.$LastName.'">
        <br>
        country:
        <br>
        <input class="form-control" type="text" name="country" value="'.$country.'">
        <br>
        regDate:
        <br>

        <input class="form-control" type="text" name="regDate" value="'.$regDate.'">
        <br>
        emailVerified:
        <br>
        <input class="form-control" type="text" name="emailVerified" value="Mouse">
         submit:
            <br>
            <button type="submit">'.$buttonText.'</button>
        </form>
        <h3>Order details</h3>

        <script> if (globalAjaxInit == true) {formSubmitEvent_bindAll();} </script>';


?>