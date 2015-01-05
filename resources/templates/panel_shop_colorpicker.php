<link rel="stylesheet" href="../public_html/css/slider.css"/>
<style rel="stylesheet">
    #RGB {
        height: 20px;
        background: rgb(128, 128, 128);
    }
    #RC .slider-selection {
        background: #FF8282;
    }
    #RC .slider-handle {
        background: red;
    }
    #GC .slider-selection {
        background: #428041;
    }
    #GC .slider-handle {
        background: green;
    }
    #BC .slider-selection {
        background: #8283FF;
    }
    #BC .slider-handle {
        border-bottom-color: blue;
    }
    #R, #G, #B {
        width: 300px;
    }
</style>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Color Picker</h3>
    </div>
    <div class="panel-body">


        <form id="form_insert_color" action="../resources/manage_db.php" method="get">
            action:
            <br>
            <input type="text" name="action" value="insert_insert_color">
            <br>
            <!--------http://www.eyecon.ro/bootstrap-slider/ -->

            <p>
                <b>R</b> <input type="text" class="span2" value=""
                                data-slider-min="0" data-slider-max="255"
                                data-slider-step="1" data-slider-value="128"
                                data-slider-id="RC" id="R"/>
            </p>
            <p>
                <b>G</b> <input type="text" class="span2" value=""
                                data-slider-min="0" data-slider-max="255"
                                data-slider-step="1" data-slider-value="128"
                                data-slider-id="GC" id="G"/>
            </p>
            <p>
                <b>B</b> <input type="text" class="span2" value=""
                                data-slider-min="0" data-slider-max="255"
                                data-slider-step="1" data-slider-value="128"
                                data-slider-id="BC" id="B"/>
            </p>
            <div id="RGB"></div>
            <br>
            <input type="text" name="RGB_hex" id="display_RGB_hex"/>
        </form>


    </div>
</div>

<!--Script for bootstrap sliders -->
<script>

    function componentToHex(c) {
        var hex = c.toString(16);
        return hex.length == 1 ? "0" + hex : hex;
    }
    function rgbToHex(r, g, b) {
        return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
    }

    var RGBChange2 = function() {
        $('#RGB').css('background', 'rgb('+r2.getValue()+','+g2.getValue()+','+b2.getValue()+')');
        $('#display_RGB_hex').val(rgbToHex(r2.getValue(), g2.getValue(), b2.getValue()));
    };

    var r2 = $('#R').slider()
        .on('slide', RGBChange2)
        .data('slider');
    var g2 = $('#G').slider()
        .on('slide', RGBChange2)
        .data('slider');
    var b2 = $('#B').slider()
        .on('slide', RGBChange2)
        .data('slider');

</script>


<?php
/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 11/27/2014
 * Time: 8:17 PM
 */ 