<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inventory</h3>
    </div>
    <div class="panel-body">



        <!-- filter items -->
        <form id="form_insert_color" action="../resources/manage_db.php" method="get">
            <br>
            <input type="hidden" type="text" name="action" value="get_item_category">

            <br>

            <!-- Dynamic filter menu for shop items -->

            <?php
                include '/../library/DB_manager.php';

                echo "<hr>";
                echo "Item category:  ";

                $xmlResponse_str = get_categories(0); // 0 not an ajax request
                $xml = new SimpleXMLElement($xmlResponse_str);
                if($xml !=null){
                    foreach($xml->children() as $category) {
                        $categoryName =  $category->category_name;
                        echo "<input style='display:inline-block;' type='checkbox' name='tableName' value='".$categoryName."'>".$categoryName;

                    }
                }
                echo "<hr>";
            ?>

            <input type="submit" value="Submit">
            <br>

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