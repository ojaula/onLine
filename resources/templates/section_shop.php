<div id="section_shop" class="tab-pane fade">
    <!--center content div -->
    <div class="row center-block " style="float: none; max-width: 900px;">
        <h3>SHOP</h3>

        <!-- shopping cart "linear chain" -->
        <div class="col-xs-12 col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Shopping Guide</h3>
                </div>
                <div class="panel-body">


                    <!-- shop Tabs Content -->

                        <?php
                            require_once(realpath(dirname(__FILE__). "/panel_shop_listItems.php"));

                            require_once(realpath(dirname(__FILE__). "/panel_shop_itemDetail.php"));

                            require_once(realpath(dirname(__FILE__). "/panel_shop_cart.php"));

                            require_once(realpath(dirname(__FILE__). "/panel_shop_details.php"));

                            require_once(realpath(dirname(__FILE__). "/panel_shop_accept.php"));
                        ?>
                    <div  class="glyphicon glyphicon-ok" id="shop_done" style="font-size:30px; color:green; display:none;">Success!</div>

                    <div style="display:inline-block; max-width: 600px; padding-right:40px;">
                    <p>Online usually ship the ordered goods within 24 hours (if they exist in our local warehouse).<br>
                        Order here or call (+46)70-5353331. All prices are in <strong>Euros including VAT</strong> and also applies in store..</p>
                    </div>
                    <div style="display:inline-block;">
                    <p> Email Us<br>
                        Call Us: (+46)70-5353331<br>
                        Customer Service Hours<br>
                        8:00AM-6:00PM Mon-Fri\<br>
                        9:00AM-2:00PM Saturday</p>
                    </div>

                    <!-- Dynamic Tabs Script-->
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#shopTab a").click(function(e){
                                e.preventDefault();
                                $(this).tab('show');
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

