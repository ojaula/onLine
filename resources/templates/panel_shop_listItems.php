



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



        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img data-src="holder.js/300x300" alt="...">
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p>

                        <table>
                            <tr>
                                <td><a href="#" class="btn btn-primary" role="button">BUY</a></td>
                                <td>
                                    Price
                                    <br>
                                    Category
                                </td>
                            </tr>
                        </table>

                        </p>
                    </div>
                </div>
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