
function addToLocalCart(jsonOBJ){
    // Put the object into storage
    // Parse the serialized data back into an aray of objects
    a = JSON.parse(localStorage.getItem('onLine_shoppingCart'));
    if(!a)
    {
        var a = [];
    }
    a.push(jsonOBJ);
    localStorage.setItem('onLine_shoppingCart', JSON.stringify(a));
}

function getLocalCart(){
    // Retrieve the object from storage
    return retrievedObject = localStorage.getItem('testObject');
}

function init_shoppingCart(){


    $('.cart_deleteButton').click(function(){
        var id = $(this).data('itemid');
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


    var panelShopping = ""+


}