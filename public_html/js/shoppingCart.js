
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