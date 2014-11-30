
<!--Site Lower Nav  -->
<!--Dynamic  Shopping route : http://www.tutorialrepublic.com/codelab.php?topic=bootstrap&file=create-dynamic-tabs-via-javascript -->
<!-- shop Tabs -->
<div class="bs-example">
    <ul class="nav nav-tabs " id="myTab" style="position:relative; top:-52px">   <!--Style used for offset menu position to header -->
        <li  class="active col-xs-offset-1"><a class="glyphicon glyphicon-pencil" href="#section_draw">Draw</a></li>
        <li><a class="glyphicon glyphicon-shopping-cart" href="#section_shop">Shop</a></li>
        <li><a class="glyphicon glyphicon-info-sign" href="#section_info">Info</a></li>
    </ul>
</div>


<!-- shop Tabs Content -->
<div class="tab-content">

    <?php
        require_once(realpath(dirname(__FILE__). "/section_draw.php"));
        require_once(realpath(dirname(__FILE__). "/section_info.php"));
        require_once(realpath(dirname(__FILE__). "/section_shop.php"));
    ?>

</div>

<!-- Dynamic Tabs Script-->
<script type="text/javascript">
    $(document).ready(function(){
        $("#myTab a").click(function(e){
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>



<?php

/*
    Any variables passed in through the variables parameter in our renderLayoutWithContentPage() function
    are available in here.
*/

echo $setInIndexDotPhp;

?>