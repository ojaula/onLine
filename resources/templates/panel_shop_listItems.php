<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inventory</h3>
    </div>
    <div class="panel-body">



        <!-- filter items -->
        <form data-callback="ajaxCallback_listShopItems" id="form_get_category_items" action="../resources/manage_db.php" method="get">
            poi id:
            <input type="text" name="category_id" value="1">
            <br>
            action:
            <input type="text" name="action" value="get_category_items">
            <br>

            <!-- Dynamic filter menu for shop items -->


            <?php
            /*
                include_once'/../library/DB_manager.php';

                echo "<hr>";
                echo "Item category:  ";

                $xmlResponse_str = get_categories(0); // 0 not an ajax request
                $xml = new SimpleXMLElement($xmlResponse_str);
                if($xml !=null){
                    foreach($xml->children() as $category) {
                        $categoryName =  $category->category_name;
                        $categoryId =  $category->category_id;
                        echo "<input style='display:inline-block;' type='checkbox' name='category_id' value='".$categoryId."'>".$categoryName;

                    }
                }
                echo "<hr>";
            */
            ?>
            <br>
            <hr>
            <button type="submit">Search</button>
        </form>


        <!-- area for deploy shop items -->
        <div class="row">
            <div id="shop_itemContainer" class="col-sm-6 col-md-4">

            </div>
        </div>




    </div>
</div>




<?php
/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 11/30/2014
 * Time: 10:00 PM
 */ 