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
                <div class="panel-body">

                    <!-- BRUSHES CONTENT -->
                    <div class="row">
                        <!-- COLOR -->
                        <div class="col-xs-2 col-md-2">
                            <button type="button" class="btn btn-default btn-xs glyphicon glyphicon-pencil">2px
                            </button>
                        </div>
                        <div class="col-xs-2 col-md-2">
                            <button type="button" class="btn btn-default btn-xs glyphicon glyphicon-pencil">4px
                            </button>
                        </div>
                        <div class="col-xs-2 col-md-2">
                            <button type="button" class="btn btn-default btn-xs glyphicon glyphicon-pencil">8px
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Colors</h3>
                </div>
                <div class="panel-body">

                    <!-- COLOR CONTENT -->
                    <div class="row">
                        <!-- COLOR -->
                        <div class="col-xs-1 col-md-1">
                            <button type="button" class="btn btn-default btn-xs">
                                <div class="thumbnail" style="background-color: #28a4c9"></div>
                            </button>
                        </div>
                        <div class="col-xs-1 col-md-1">
                            <button type="button" class="btn btn-default btn-xs">
                                <div class="thumbnail" style="background-color: #28a4c9"></div>
                            </button>
                        </div>
                        <div class="col-xs-1 col-md-1">
                            <button type="button" class="btn btn-default btn-xs">
                                <div class="thumbnail" style="background-color: #28a4c9"></div>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <!-- COLOR -->
                        <div class="col-xs-1 col-md-1">
                            <button type="button" class="btn btn-default btn-xs">
                                <div class="thumbnail" style="background-color: #28a4c9"></div>
                            </button>
                        </div>
                        <div class="col-xs-1 col-md-1">
                            <button type="button" class="btn btn-default btn-xs">
                                <div class="thumbnail" style="background-color: #28a4c9"></div>
                            </button>
                        </div>
                        <div class="col-xs-1 col-md-1">
                            <button type="button" class="btn btn-default btn-xs">
                                <div class="thumbnail" style="background-color: #28a4c9"></div>
                            </button>
                        </div>
                    </div>
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
