<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Shopping Cart</h3>
    </div>
    <div class="panel-body">
        <!--
        <div ng-app="myApp">
            <div ng-controller="shoppingCart_controller">
                <p>    Click <a ng-click="updateChart()">here</a> to load data.</p>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                    <tr ng-repeat="item in items">
                        <td>{{item.item_id}}</td>
                        <td>{{item.item_name}}</td>
                        <td>{{item.item_price}}</td>

                        category_id: "1"
                        itemCategory_id: "1"
                        item_color: "0"
                        item_descLong: "Mouse"
                        item_descShort: "Mouse"
                        item_id: "1"
                        item_image: "Mouse"
                        item_name: "Mickey"
                        item_price: "1"
                        item_rank: "5"
                        item_stock: "4"
                        item_update: "2005-03-30 00:00:00"item_weight: "2"


                    </tr>
                </table>
            </div>
        </div>
        -->

        <form data-callback="ajaxCallback_createdOrder" action='../resources/manage_db.php' method='get' id='form_cart'>
            <input type="hidden" name="action" value="accept_shoppingCart">

            <!-- deploy chart content/ items -->
            <table id ="chart_productlist" class="chart_productlist">
            </table>

            Accept ShoppingChart:
            <br>
            <input  type="submit" value="Checkout">
            <br>
        </form>
        <p id="form_cart_message"></p>

    </div>


    <script>
        //temp resetter
        //localStorage.setItem('onLine_shoppingCart', JSON.stringify([]));

        // global var for choppingCart content
        //loadLocalCart();    //load to global shoppingCart_list
        loadShoppingCart()

        //var shoppingCart_list = [];
        var shoppingCart_list2 = [
            {
                item_id: 1,
                item_name: "Peter",
                item_price: "Jhons"},
            {
                item_id: 2,
                item_name: "Peter2",
                item_price: "Jhons2"}
        ];
         //localStorage.setItem('onLine_shoppingCart', JSON.stringify(shoppingCart_list));
        //console.log(shoppingCart_list2);


        //var shoppingCart = getLocalCart();

        function shoppingCart_insert(itemId){

            var itemOBJ=global_object_dict[itemId];
            var itemQuantity = document.getElementById("item_"+itemId).value;

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
            //store new value in localstorage
            cart_addItem(jsonOBJ);
            //update local cart model
            //loadLocalCart();
            //shoppingCart_list.push(jsonOBJ);
            loadShoppingCart();
        }

        function cart_addItem(jsonOBJ){
            // Put the object into storage
            // Parse the serialized data back into an aray of objects

            var cart =cart_load();

            // add quantity value in the time object as an pre order detail.
            jsonOBJ.item["item_quantity"]=1;

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
            loadShoppingCart();
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
            loadShoppingCart();
        }

        function loadShoppingCart(){

            var cartContainer = document.getElementById("chart_productlist");
            var chartJson =cart_load();

            cartContainer.innerHTML = "";
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

        var app = angular.module('myApp', []);

        function shoppingCart_controller($scope, $http) {

            $scope.items = [];

            //$scope.items = shoppingCart_list2;


            $scope.updateChart = function() {

                /*
                 var httpRequest = $http({
                 method: 'POST',
                 url: '/echo/json/',
                 data: shoppingCart_list2

                 }).success(function(data, status) {
                 $scope.people = data;
                 });
                 */

                $scope.items= shoppingCart_list;
            };


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