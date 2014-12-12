<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Shopping Cart</h3>
    </div>
    <div class="panel-body">


        <form action='../resources/manage_db.php' method='get' id='form_cart'>
            <input type="hidden" name="action" value="accept_shoppingCart">

            <!-- deploy chart content/ items -->
            <table class="chart_productlist">
            </table>

            Accept ShoppingChart:
            <br>
            <input type="submit" value="Submit">
            <br>
        </form>

    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 12/12/2014
 * Time: 9:37 AM
 */
?>