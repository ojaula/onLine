<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Shopping Cart</h3>
    </div>
    <div class="panel-body">


        <div ng-app="myApp">
            <div ng-controller="shoppingCart_controller">
                <p>    Click <a ng-click="loadPeople()">here</a> to load data.</p>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                    <tr ng-repeat="person in people">
                        <td>{{item.item_id}}</td>
                        <td>{{item.item_name}}</td>
                        <td>{{item.item_price}}</td>
                    </tr>
                </table>
            </div>
        </div>


        <form action='../resources/manage_db.php' method='get' id='form_cart'>
            <input type="hidden" name="action" value="accept_shoppingCart">

            <!-- deploy chart content/ items -->
            <table class="chart_productlist">
            </table>

            Accept ShoppingChart:
            <br>
            <input type="submit" value="Submit">
            <br>
        </form>

    </div>


    <script>

        var shoppingCart_list = [
                {
                    item_id: 1,
                    item_name: "Peter",
                    item_: "Jhons"},
                {
                    id: 2,
                    firstName: "David",
                    lastName: "Bowie"}
            ];

        var shoppingCart = getLocalCart();

        var app = angular.module('myApp', []);


        function shoppingCart_insert(itemOBJ){
            var jsonOBJ;
            try
            {
                var x2js = new X2JS();
                jsonOBJ = x2js.xml_str2json( itemOBJ );
            }
            catch(e){
                alert("could not convert xml, must be json already!");
                jsonOBJ = itemOBJ;
            }
            //store new value in localstorage
            addToLocalCart(jsonOBJ);
            //update local cart model
            shoppingCart = getLocalCart();
        }


        function shoppingCart_controller($scope, content) {




            $scope.people = [];
            $scope.people= angular.fromJson(shoppingCart_list);


            /*
            $scope.loadPeople = function() {
                var httpRequest = $http({
                    method: 'POST',
                    url: '/echo/json/',
                    data: mockDataForThisTest

                }).success(function(data, status) {
                    $scope.people = data;
                });

            };
            */

        }


        function addToLocalCart(jsonOBJ){
            // Put the object into storage
            // Parse the serialized data back into an aray of objects
            a = JSON.parse(localStorage.getItem('onLine_shoppingCart'));
            if(!a)
            {
                var a = '"items":[]}';
            }
            a.push(jsonOBJ);
            localStorage.setItem('onLine_shoppingCart', JSON.stringify(a));
        }

        function getLocalCart(){
            // Retrieve the object from storage
            a = JSON.parse(localStorage.getItem('onLine_shoppingCart'));
            if(!a)
            {
                var a = '"items":[]}';
                localStorage.setItem('onLine_shoppingCart', JSON.stringify(a));
                return  JSON.parse(localStorage.getItem(a));
            }
            else
            {
                return  JSON.parse(localStorage.getItem('onLine_shoppingCart'));
            }
        }

        function init_shoppingCart(){

            $('.cart_deleteButton').click(function(){
                var id = $(this).data('item_id');
                $(this).remove();
                localStorage.clear();
                console.log(JsonData);

                var data = JSON.parse(JsonData),
                    indexToRemove = null;

                $.each(data['items'], function(idx, obj){
                    if (obj['id'] == id) {
                        indexToRemove = idx;
                        return false;
                    }
                });

                if (indexToRemove !== null) {
                    data['items'].splice(indexToRemove, 1);
                }

                var Count = 0;
                localStorage.setItem(Count, JSON.stringify(data));
                JsonData = localStorage.getItem(Count);
            });
        }

        function loadShoppingCart(placmentContainer){


            var chartJson =getLocalCart();

            for (var i = 0; i < chartJson.items.length; i++) {
                alert(chartJson.items[i].item_id);
            }


            var chart_item = ""+
                '<tr class="">'+
                '<td class="picture left_corner">'+
                '<img src="https://www.webhallen.com/image/product/161184/mini" alt="">'+
                '</td>'+
                '<td class="prod_name" style="min-width:450px">'+
                '<p><a href="/se-sv/spel/nintendo_wii_u/161184-bayonetta_2_special_edition">Bayonetta 2 Special Edition (Bayonetta 1 + 2)</a></p><nobr>'+
                '<p class="prod_artnr"><nobr>Artikelnummer: 161184</p>'+
                '<input type"hidden" name="item_id[]">'+
                '</td>'+
                '<td class=" prod_amount">'+
                '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>'+
                '<input type="text" size="3" class="input_amount" value="1" name="item_amount[]"> st :'+
                '</td>'+
                '<td class="prod_price">499 kr</td>'+
                '<td class="prod_remove">'+
                '<button class="glyphicon glyphicon-remove" aria-hidden="true"></button>'+
                '</td>'+
                '<td class="stock">'+
                '<div class="stock_popup last">'+
                '<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>'+
                '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>'+
                '</tr>';

            placmentContainer.innerHTML = chart_item;

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