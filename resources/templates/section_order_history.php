<div id="section_oder_history" class="tab-pane fade">
    <!--center content div -->
    <div class="row center-block " style="float: none; max-width: 900px;">
        <h3>Customer Interface</h3>

        <!-- shopping cart "linear chain" -->
        <div class="col-xs-12 col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order History</h3>
                </div>
                <div class="panel-body">
                    <table>
                    <?php
                   // require_once(realpath(dirname(__FILE__). "/content_personalDetails.php"));
                    require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));
                    if(!isset($_SESSION)){
                        session_start();
                    }

                    // is logged in?
                    if(isset($_SESSION['sess_user_id']))
                    {
                        $userCurrentOrderHistory = get_order_orderHistory(0, $_SESSION['sess_user_id']);
                        $userCurrentOrderHistoryOBJ = new SimpleXMLElement($userCurrentOrderHistory);
                        $orderHistory = $userCurrentOrderHistoryOBJ->orderHistory;

                        echo "<table class='table'>";
                        $totalPris =0;

                        foreach($userCurrentOrderHistoryOBJ as $orderHistory)
                        {
                            $price = $orderHistory->orderDetails_quantity * $orderHistory->orderDetails_price;
                            $totalPris+=$price;
                            echo "<tr>";
                            echo "<td style='min-width:450px'>Title: ".$orderHistory->orderDetails_name."</td>";
                            echo "<td style='min-width:110px'>Quantity: ".$orderHistory->orderDetails_quantity."</td>";
                            echo "<td>Price: ".$price."</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>