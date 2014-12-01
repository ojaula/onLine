



<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inventory</h3>
    </div>
    <div class="panel-body">



        <!-- filter items -->
        <form id="form_insert_color" action="../resources/manage_db.php" method="get">
            action:
            <br>
            <input type="text" name="action" value="insert_insert_color">

            Category:
            <input type="radio" name="tableName" value="itemModifiers">itemModifiers
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
                        echo "<input style='display:inline-block;' type='radio' name='tableName' value='".$categoryName."'>".$categoryName;

                    }
                }




                echo "<hr>";
            ?>

            <div id="RGB"></div>
            <br>
            <input type="text" name="RGB_hex" id="display_RGB_hex"/>
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