<div id="section_order_history" class="tab-pane fade">
    <!--center content div -->
    <div class="row center-block " style="float: none; max-width: 900px;">
        <h3>SHOP</h3>

        <!-- shopping cart "linear chain" -->
        <div class="col-xs-12 col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order Details</h3>
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
                            <div id="shop_sectionB" class="tab-pane fade">
                                <h3>Section B</h3>
                                <p>Vestibulum nec erat eu nulla .</p>
                            </div>
                            <div id="shop_sectionC" class="tab-pane fade">
                                <h3>SectionC</h3>
                                <p>WInteger convallis, nulla in </p>
                            </div>
                        </div>
                    </div>
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

