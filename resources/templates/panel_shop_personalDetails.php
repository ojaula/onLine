
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Personal details</h3>
    </div>
        <!-- Hidden block , will show when user checkout the shoppingcart -->
        <div id="shop_personaldetails_body" class="col-xs-12 col-md-6" style="display: none; border:1px #dcdcdc solid;border-radius:5px;">
            <h3>Order details</h3>
            <form id="form_insert_order" action="../resources/manage_db.php" method="get">
                action:
                <input class="form-control" type="hidden" name="action" value="insert_order">
                user id:
                <input class="form-control" type="text" name="user_id" value="1">
                shipName:
                <input class="form-control" type="text" name="ship_name" value="1">
                shipAddress:
                <input class="form-control" type="text" name="ship_address" value="1">
                shapName:
                <input class="form-control" type="text" name="ship_zip" value="1">
                ship_city:
                <input class="form-control" type="text" name="ship_city" value="1">
                ship_country:
                <input class="form-control" type="text" name="ship_country" value="1">
                shipping:
                <input class="form-control" type="text" name="shipping" value="1">
                phone:
                <input class="form-control" type="text" name="phone" value="1">
                tax:
                <input class="form-control" type="text" name="tax" value="1">
                date:
                <input class="form-control" type="hidden" name="date" value="1">
                paymentId:
                <input class="form-control" type="hidden" name="paymentId" value="0">
                transactStatus:
                <input class="form-control" type="hidden" name="transactStatus" value="0">
                shipped:
                <input class="form-control" type="hidden" name="shipped" value="0">
                fullfilled:
                <input class="form-control" type="hidden" name="fullfilled" value="0">
                submit:
                <br>
                <button type="submit">Submit</button>
            </form>
        </div>

        <div id="shop_userdetails_body" class="col-xs-12 col-md-6" style="display: none; border:1px #dcdcdc solid;border-radius:5px;">
            <?php
                if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == ''))
                {
                    echo' <div class="boxtitle">You are not logged in!</div>';
                    echo' <div class="formrow">If you are not logged in, you want be able to receive the digital goods. However, we gladly accept your donations!</div>';
                    //header("location: login.html");
                    require(TEMPLATES_PATH . "/header_unregistered.php");
                }
                else
                {
                    require(TEMPLATES_PATH . "/header_hasLoggedin.php");

                }

            ?>

            <h3>User Details</h3>
            <form id="form_insert_user" action="../resources/manage_db.php" method="get">

                First Name:<br>
                <input type="text" name="firstName" value="Mickey">
                <br>
                Last Name:
                <br>
                <input type="text" name="lastName" value="Mouse">
                <br>
                password:
                <br>
                <input type="text" name="password" value="Mouse">
                <br>
                email:
                <br>
                <input type="text" name="email" value="Mouse">
                <br>
                phone:
                <br>
                <input type="text" name="phone" value="Mouse">
                <br>
                address:
                <br>
                <input type="text" name="address" value="Mouse">
                <br>
                zip:
                <br>
                <input type="text" name="zip" value="Mouse">
                <br>
                city:
                <br>
                <input type="text" name="city" value="Mouse">
                <br>
                country:
                <br>
                <input type="text" name="country" value="Mouse">
                <br>
                regDate:
                <br>
                <input type="text" name="regDate" value="Mouse">
                <br>

                submit:
                <br>
                <input type="submit" value="Submit">
                <br>
            </form>


    </div>




</div>

<!-- hidden should be removed to server side!!! -->



<?php
/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 12/10/2014
 * Time: 8:16 PM
 */