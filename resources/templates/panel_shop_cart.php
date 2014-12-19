<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Shopping Cart</h3>
    </div>
    <div class="panel-body">

        <form data-callback="ajaxCallback_createdOrder" action='../resources/manage_db.php' method='get' id='form_cart'>
            <input type="hidden" name="action" value="accept_shoppingCart">

            <!-- deploy chart content/ items -->
            <table id ="chart_productlist" class="chart_productlist">
            </table>

            Accept ShoppingChart:
            <br>
            <input id="checkOutButton" type="submit" value="Checkout"  >
            <br>
        </form>
        <p id="form_cart_message"></p>

    </div>


    <script>
        //temp resetter
        //localStorage.setItem('onLine_shoppingCart', JSON.stringify([]));

        cart_loadToView()

        // PD function that checks the cart size to enable / disable "CHECKOUT button
        function cartSizeCheck()
        {
            var cartContainer = document.getElementById("chart_productlist");
            var chartJson =cart_load();

            console.log("cartSizeCheck " + chartJson.length.toString());
            if(chartJson.length <= 0)
            {

                disableCheckOutButton();

            }
            else
            {
                enableCheckOutButton();
            }
        }

        // PD disable "CHECKOUT button AND eliminate the personal-order details, Leaves a sloppy "border" line left.
        function disableCheckOutButton()
        {
            console.log("disableCheckOutButton");
            document.getElementById("checkOutButton").disabled=true;
            var user_details = document.getElementById("shop_userdetails_body");
            if (user_details != undefined)
            {
                user_details.innerHTML = "";
            }

        }

        // PD function that  enable  "CHECKOUT button
        function enableCheckOutButton()
        {
            console.log("enableCheckOutButton");
            document.getElementById("checkOutButton").disabled=false;
        }

        function cart_addItemXML(itemId){

            var itemOBJ=global_object_dict[itemId];

            var jsonOBJ;
            //try to convert xml to json, database xmlrequest needs to be converted to angularjs json format.
            try
            {
                var x2js = new X2JS();
                jsonOBJ = x2js.xml_str2json(itemOBJ.outerHTML);
                //alert("converted xml to Json");
            }
            catch(e){
                //alert("could not convert xml, must be json already!");
                jsonOBJ = itemOBJ;
            }

            // add quantity value in the time object as an pre order detail.
            var itemQuantity = document.getElementById("item_"+itemId).value;
            jsonOBJ.item["item_quantity"]=itemQuantity;

            //store new value in localstorage
            cart_addItem(jsonOBJ);
            cart_loadToView();
        }

        function cart_addItem(jsonOBJ){
            // Put the object into storage
            // Parse the serialized data back into an array of objects

            var cart =cart_load();

            cart.push(jsonOBJ["item"]);
            console.log(cart);
            localStorage.setItem('onLine_shoppingCart', JSON.stringify(cart));

        }



        function cart_load(){
            // Retrieve the object from storage
            var ret=[];
            return JSON.parse(localStorage.getItem('onLine_shoppingCart')) || ret;
        }


        function cart_deleteitem(item_id){
            // Put the object into storage
            // Parse the serialized data back into an aray of objects
            var chartJson;
            try{
                chartJson = JSON.parse(localStorage.getItem('onLine_shoppingCart'));

            }catch(e){
                return false;
            }
            for (var i = 0; i < chartJson.length; i++)
            {
                var obj = chartJson[i];
                if(obj.item_id==item_id){
                    chartJson.splice(i,1);
                    break;
                }
            }
            localStorage.setItem('onLine_shoppingCart', JSON.stringify(chartJson));
            cart_loadToView();
        }
        function cart_updateitemQuantity(item_id,valueSource){
            // Put the object into storage
            // Parse the serialized data back into an aray of objects
            var itemQuantity = document.getElementById(valueSource).value;

            var chartJson;
            try{
                chartJson = JSON.parse(localStorage.getItem('onLine_shoppingCart'));

            }catch(e){
                return false;
            }
            for (var i = 0; i < chartJson.length; i++)
            {
                var obj = chartJson[i];
                if(obj.item_id==item_id){
                    chartJson[i]["item_quantity"]= itemQuantity;
                    break;
                }
            }
            localStorage.setItem('onLine_shoppingCart', JSON.stringify(chartJson));
            cart_loadToView();
        }

        function cart_loadToView(){

            var cartContainer = document.getElementById("chart_productlist");
            var chartJson =cart_load();

            cartContainer.innerHTML = "";
            cartSizeCheck();
            for (var i = 0; i < chartJson.length; i++) {
                var obj = chartJson[i];
                //alert(obj.item_id);

                console.log(obj.item_quantity);

                var chart_item = ""+
                    '<tr class=\'chartOBJ'+obj.item_id+'\'>'+
                    '<td class="picture left_corner">'+
                    '<img src="https://www.webhallen.com/image/product/161184/mini" alt="">'+
                    '</td>'+
                    '<td class="prod_name" style="min-width:450px">'+
                    '<p><a href="/se-sv/spel/nintendo_wii_u/161184-bayonetta_2_special_edition">'+obj.item_name+' : '+obj.item_descShort+'</a></p><nobr>'+
                    '<p class="prod_artnr"><nobr>Artikelnummer: '+obj.item_id+'</p>'+
                    '<input type="hidden" name="chart_Item_Id[]" value="'+obj.item_id+'">'+
                    '</td>'+
                    '<td class=" prod_amount">'+
                    '<span class="glyphicon glyphicon-refresh" onclick="cart_updateitemQuantity(\''+obj.item_id+'\',\'item_quantity'+obj.item_id+'\')" aria-hidden="true"></span>'+
                    '<input type="text" size="3" onblur="cart_updateitemQuantity(\''+obj.item_id+'\',\'item_quantity'+obj.item_id+'\')" id="item_quantity'+obj.item_id+'" value="'+obj.item_quantity+'" name="chart_item_amount[]"> st :'+
                    '</td>'+
                    '<td class="prod_price">'+obj.item_price+' kr</td>'+
                    '<td class="prod_remove">'+
                    '<button class="glyphicon glyphicon-remove" onclick="cart_deleteitem('+obj.item_id+')" aria-hidden="true"></button>'+
                    '</td>'+
                    '<td class="stock">'+
                    '<div class="stock_popup last">'+
                    '<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>'+
                    '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>'+
                    '</tr>';

                cartContainer.innerHTML += chart_item;
            }


        }

    </script>



</div>


<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 12/12/2014
 * Time: 9:37 AM
 */
?>