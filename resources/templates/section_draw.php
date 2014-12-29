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
                        //require_once(TEMPLATES_PATH . "/panel_user_list_color.php");
                        require_once(realpath(dirname(__FILE__). "/panel_shop_colorpicker.php"));
                        ?>

                </div>
            </div>
        </div>
    </div>

    <!-- CANVAS -->
    <div class="row">
        <div class="center-block canvasWrapper " style="float: none; max-width: 900px;">
            <!--<canvas style=" margin:auto ;border:1px solid black"></canvas>-->
            <div id="xycoordinates" style="border:1px solid black:width:500px;"></div>
            <canvas id="myCanvas" width="900" height="600" style="border:1px solid #d3d3d3; overflow:"hidden"" onmousedown="mouseDown(event)" onmousemove="cnvs_getCoordinates(event)" onmouseup="mouseUp(event)" onmouseout="cnvs_clearCoordinates()">
                Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
    </div>
</div>
