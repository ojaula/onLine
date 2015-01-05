<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Item detail</h3>
    </div>
    <div class="panel-body">
        <div id="itemDetailSection">

        </div>
    </div>
</div>
<script>
    function loadItemDetail(item_id){
        $("#itemDetailSection").load("../resources/templates/content_itemDetail.php",{"item_id":item_id})
    }
    function addComment(commentForm, item_id)
    {
        //send form with jquery
        //alert(commentForm);
        console.log($("."+commentForm).serializeArray());

        $.ajax({
            type: "POST",
            url: "../resources/library/DB_manager.php",
            data: $("."+commentForm).serializeArray(),
            cache: false,
            success:  function(data){
                /* alert(data); if json obj. alert(JSON.stringify(data));*/
                //alert("message sent");
                loadItemDetail(item_id);
            }
        });

        //$("#itemDetailSection").load("../resources/templates/content_itemDetail.php",{"item_id":item_id})
    }
</script>

<?php
/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 12/29/2014
 * Time: 8:36 PM
 */
?>