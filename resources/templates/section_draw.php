<div id="section_draw" class="tab-pane fade in active">

    <!--center content div -->
    <div class="row center-block " style="float: none; max-width: 900px;">
        <h3>DRAW</h3>

        <!--TOOLS -->
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Brushes</h3>
                </div>
                <div class="panel-body" id="toolList">

                    <!-- TOOL / BRUSH CONTENT -->
                        <?php
                        require_once(TEMPLATES_PATH . "/panel_user_list_tool.php");
                        ?>


                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Colors</h3>
                </div>
                <div class="panel-body" id="colorList">

                    <!-- COLOR CONTENT -->

                        <!-- COLOR -->

                        <?php
                        require_once(TEMPLATES_PATH . "/panel_user_list_color.php");


                        ?>


                </div>
            </div>
        </div>
    </div>
    <?php
        require_once(realpath(dirname(__FILE__). "/panel_shop_colorpicker.php"));
    ?>

    <!-- CANVAS -->
    <div class="row">
        <div class="center-block canvasWrapper " style="float: none; max-width: 900px;">
            <canvas style=" margin:auto ;border:1px solid black"></canvas>
        </div>
    </div>
</div>
