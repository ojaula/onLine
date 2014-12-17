<div id="section_user_details" class="tab-pane fade">
    <!--center content div -->
    <div class="row center-block " style="float: none; max-width: 900px;">
        <h3>SHOP</h3>

        <!-- shopping cart "linear chain" -->
        <div class="col-xs-12 col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Details</h3>
                </div>
                <div class="panel-body">


                    <!--Dynamic  Shopping route : http://www.tutorialrepublic.com/codelab.php?topic=bootstrap&file=create-dynamic-tabs-via-javascript -->
                    <!-- shop Tabs -->
                    <div class="bs-example">
                        <ul class="nav nav-tabs" id="shopTab">
                            <li  class="active" glyphicon glyphicon-arrow-right><a class="glyphicon glyphicon-arrow-right" href="#shop_sectionA">Section A</a></li>
                            <li><a class="glyphicon glyphicon glyphicon-arrow-right" href="#shop_sectionB">Section B</a></li>
                            <li><a class="glyphicon glyphicon-ok" href="#shop_sectionC">Section C</a></li>
                        </ul>


                        <!-- shop Tabs Content -->
                        <div class="tab-content">
                            <div id="shop_sectionA" class="tab-pane fade in active">
                                <h3>Section A</h3>

                                <?php
                                    require_once(realpath(dirname(__FILE__). "/panel_shop_listItems.php"));

                                    require_once(realpath(dirname(__FILE__). "/panel_shop_cart.php"));

                                    require_once(realpath(dirname(__FILE__). "/panel_shop_personalDetails.php"));
                                ?>

                            </div>

                        </div>
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

