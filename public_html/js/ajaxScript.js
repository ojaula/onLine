

    //----global----
    //global dict for holding items being viewed in shop.
    //used for smoother integration with the choppingCart.
    var global_object_dict = {};
    // Ajax object
    var xmlhttp = new XMLHttpRequest();
    //response feedback display target
    var respArea = document.getElementById("responseArea");
    //store result
    var ajaxResponse;

    formSubmitEvent_bindAll();

    function formSubmitEvent_bindAll(){
        //Bind all buttons from forms to send ajax post message     ($('form[name="sub"]').onsubmit = function(e) {    // ajax dont seem to work.)
        // loop though all elements
        var elems = document.getElementsByTagName('form'), i;
        for (i in elems) {
            elems[i].onsubmit = function(e){formSubmitEvent(e);};
        }
    }

    function logInAttempt(username,password)
    {
        console.log("logOutAttempt");
        xmlhttp = new XMLHttpRequest(); //create request;
        //set callback function
        var callback = "ajaxCallback_loginEvent";
        xmlhttp.onreadystatechange= function(){serverResponseCheck(callback);};
        //send te request
        xmlhttp.open("POST", "../resources/library/DB_manager.php?", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        xmlhttp.send("action=get_login&username="+username+"&password="+password+"");
    }
    function logOutAttempt()
    {
        console.log("logOutAttempt");
        xmlhttp = new XMLHttpRequest(); //create request;
        //set callback function
        var callback = "ajaxCallback_logOutEvent";
            xmlhttp.onreadystatechange= function(){serverResponseCheck(callback);};
        //send te request
        xmlhttp.open("POST", "../resources/library/DB_manager.php?", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        xmlhttp.send("action=set_logout");
    }
    function formSubmitEvent(e){

        //suppress the usual page transfer
        e.preventDefault();

        var f = e.target;
        var formData = new FormData(f); // load all data from form tags
        xmlhttp = new XMLHttpRequest(); //create request;

        //set callback function
        var callback = f.getAttribute("data-callback")|| "ajaxCallback_std";

        xmlhttp.onreadystatechange= function(){serverResponseCheck(callback);};

        //send te request
        xmlhttp.open("POST", "../resources/library/DB_manager.php?", true);
        xmlhttp.send(formData);
    }

    // send specific ajax request using get.
    function sendRequest_get(str)
    {
        if (str.length==0)
        {
            return;
        }
        xmlhttp=new XMLHttpRequest(); //create request;
        //set callback function -> print php echo on page response section.

        //set callback function
        f =document.getElementById("get_items");
        var callback = f.getAttribute("data-callback")|| "ajaxCallback_std";

        xmlhttp.onreadystatechange= function(){serverResponseCheck(callback);};

        xmlhttp.open("GET","../resources/libraryDB_manager.php?"+str,true);
        xmlhttp.send();
    }

    // send specific ajax request using get.
    function sendRequest_post(str,callback)
    {
        if (str.length==0)
        {
            return;
        }
        xmlhttp=new XMLHttpRequest(); //create request;

        //set callback function
        //f =document.getElementById("get_items");
        var callback = callback|| "ajaxCallback_std";

        xmlhttp.onreadystatechange= function(){serverResponseCheck(callback);};

        xmlhttp.open("POST", "../resources/library/DB_manager.php?", true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send(str);
    }

    //server response status check and get request.
    function serverResponseCheck(callback)
    {
        
        var printStatus = 1;
        // debug prints!
        if(xmlhttp.readyState==1)
        {
            if(printStatus)
            {
                respArea.innerHTML="--------------------------------<br>\n";
                respArea.innerHTML+="Server connection established!<br>\n";
            }
        }
        else if(xmlhttp.readyState==2)
        {
            if(printStatus)
            {
                respArea.innerHTML+="Server request received!<br>\n";
            }
        }
        else if(xmlhttp.readyState==3)
        {
            if(printStatus)
            {
                respArea.innerHTML+="Server processing request!<br>\n";
            }
        }
        else if (xmlhttp.readyState==4  && printStatus)
        {
            if(printStatus)
            {
                respArea.innerHTML += "-----response:-----<br>\n";
            }
            if (xmlhttp.status == 200)  // connection and request was successful!
            {
                handleResponse(callback,xmlhttp);
                respArea.innerHTML+="\nServer is finished!<br>\n";
            }
            else
            {
                alert(xmlhttp.statusText);
            }
        }

    }
    //handle response from ajax
    function handleResponse(callback,xmlhttp){
        // if xml file
        if(xmlhttp.responseXML)
        {
            try
            {
                ajaxResponse = xmlhttp.responseXML; // store callback global
                window[callback]();                 // execute callback from string
            }
            catch(err)
            {
                ajaxResponse=null;
                window[callback]();
                console.log("Error parsing XML file!");
            }
        }

        //if plaintext -> probably json
        else if(xmlhttp.responseText)
        {
            // parse plain text to json.
            try{
                // handle as xml if plain text to
                //ajaxResponse = JSON.parse(xmlhttp.responseText);
                var parser = new DOMParser();
                var xmlDoc = parser.parseFromString(xmlhttp.responseText, "application/xml");
                ajaxResponse =  xmlDoc;
                window[callback]();
            }
            catch(err){
                ajaxResponse=null;
                window[callback]();
                console.log("retrieving plain text!");
            }
        }
        else{
            ajaxResponse=null;
            window[callback]();
            console.log("received null!");
        }
    }

    //print names of items....test
    function ajaxCallback_listShopItems()
    {
        //reset container that shows items
        var deployContainer = document.getElementById("shop_itemContainer");
        deployContainer.innerHTML = "";

        // create lists of contents
        var xmlObj = ajaxResponse;

        var item_name       = xmlObj.getElementsByTagName("item_name");
        var item_id         = xmlObj.getElementsByTagName("item_id");
        var item_price      = xmlObj.getElementsByTagName("item_price");
        var item_descShort  = xmlObj.getElementsByTagName("item_descShort");
        var item_image      = xmlObj.getElementsByTagName("item_image");
        var item_category   = xmlObj.getElementsByTagName("category_id");
        var item            = xmlObj.getElementsByTagName("item");

        //store objects for choppingCart
        for(var j=0;j<item.length;j++){
            //var parser = new DOMParser();
            //global_object_dict[item_id[j].textContent]= parser.parseFromString(item[j], "application/xml");
            global_object_dict[item_id[j].textContent]= item[j];
        }

        for (var i=0;i<item_name.length; i++)
        {
            //no callbacks for now, calculate price on serverside
            //onsubmit="function(e){formSubmitEvent(e);}"
            var form =''+
                '<form id="" action="../resources/manage_db.php" method="get">'+
                    '<input type="hidden" type="text" name="action" value="insert_orderDetail">'+
                    '<input type="hidden" type="text" name="name" value="1">'+
                    'QTY:'+
                    '<input id="item_'+item_id[i].textContent+'" type="text" maxlength="1" size="2" name="quantity" value="1">'+
                    '<button onclick="cart_addItemXML('+item_id[i].textContent+')">BUY</button>'+
                '</form>';

            // check if if item is a color
            if (item_category[i].textContent==2){}
            var thumnail = '' +
                '<div style="display: inline-block; max-height=40px; max-width=50px;" onclick="loadItemDetail(\''+item_id[i].textContent+'\')" class="thumbnail">'+
                '<img data-src="'+item_image[i]+'" alt="...">'+
                '<div class="caption">'+
                    '<h3>'+ item_name[i].textContent +'</h3>'+
                    '<p>'+
                        item_price[i].textContent+
                        '<br>' +
                        +item_category[i].textContent+' : '+
                        item_descShort[i].textContent+
                        form +
                    '</p>'+
                '</div>'+
            '</div>';

            deployContainer.innerHTML += thumnail;
        }

        // set ajax event to all forms WARNING! this is not optimized, update all forms!
        formSubmitEvent_bindAll();
    }

    function ajaxCallback_logOutEvent(){
        var xmlObj = ajaxResponse;
        var loginUser  = xmlObj.getElementsByTagName("logout");

        if(loginUser.length<1)
        {
            console.log("user did not exist to logout");
        }
        else
        {
            console.log("user did exist and we logged out");

            // header
            var headerDeployDiv = document.getElementById("header_userSection");


          // nav bar info
            $("#header_userSection").load("../resources/templates/header_unregistered.php");

            // Available Tools
            //$("#toolList").load("../resources/templates/panel_user_list_tool.php");

            //$("#colorList").load("../resources/templates/panel_user_list_color.php");
            //$("#section_draw").tab('show');
            window.location.reload();
            //set only std tools state
            var canvas_tools={"1":drawing_line_2px,
                "2":drawing_line_4px,
                "3":drawing_line_8px};

        }

        //change header bar
        //change shop bar

    }

    function ajaxCallback_loginEvent(){
        var xmlObj = ajaxResponse;
        var loginUser  = xmlObj.getElementsByTagName("loginUser");

        if(loginUser.length<1)
        {
            console.log("user did not exist");
        }
        else
        {
            console.log("user did exist");

            $("#header_userSection").load("../resources/templates/header_hasLoggedin.php");


            // Available Tools for selection
            $("#toolList").load("../resources/templates/panel_user_list_tool.php");
            //load tool state object
            $.ajax({
                type:"POST",
                url:"../resources/templates/tool_hash.php",
                dataType: 'json',
                success: function (html) {
                    canvas_tools= html;
                    console.log("loaded tool state");
                    console.log(html);
                }
            });
            //$("#a_link")[0].click();
          window.location.reload();

        }

        //change header bar
        //change shop bar

    }
    /*
    function ajaxCallback_additemToCart()
    {
        shoppingCart_insert(ajaxResponse);
    }
    */

    function ajaxCallback_createdOrder()
    {
        //alert("created Order callback");
        var xmlObj = ajaxResponse;
        if(!xmlObj)
        {
            //alert("created Order callback");
            document.getElementById("form_cart_message").innerHTML= "<strong style='color:#ff0000;'>Not logged in!</strong>";
        }
        else
        {
            document.getElementById("form_cart_message").innerHTML= "";
            //document.getElementById("shop_personaldetails_body").style.display ="block";
            document.getElementById("shop_userdetails_body").style.display ="block";
            $("#shop_userdetails_body").load("../resources/templates/content_personalDetails.php");
        }
    }
    function ajaxCallback_userCreateAndLogin() {
        var xmlObj = ajaxResponse;
        console.log("ajaxCallback_userCreateAndLogin");
        if (xmlObj != null) {
            console.log("ajaxCallback_userCreateAndLogin xmlObj != null");
            var didSucceedNodes = xmlObj.getElementsByTagName("didSucceed");
            var didfailNodes = xmlObj.getElementsByTagName("didFail");
            if (didSucceedNodes.length == 1 && didfailNodes.length == 0)
            {
                console.log("ajaxCallback_userCreateAndLogin local storage access");
                var username = localStorage.getItem("createUserEmail");
                var pass = localStorage.getItem("createUsersPass");
                alert("Contrats you've created an account. I shall attempt to log you in with \n user: " + username + "\nPassword: " + pass);

                logInAttempt(username, pass);
            }
            else
            {
                alert("can not create user ");

            }
            console.log("ajaxCallback_userCreateAndLogin didSucceedNodes = " + didSucceedNodes);
            //var didSucceed = didSucceedNodes.firstChild.getAttribute("att");
            console.log("ajaxCallback_userCreateAndLogin didfailNodes = " + didfailNodes);
        }

        //}
        localStorage.removeItem("createUserEmail");
        localStorage.removeItem("createUsersPass");
    }
    function ajaxCallback_updateOrderDetails()
    {
        var xmlObj = ajaxResponse;
        //alert("ajaxCallback_updateOrderDetails")
        //$("#shop_userdetails_body").load("../resources/templates/content_personalDetails.php");
        $("#shop_accept_body").load("../resources/templates/content_order_summary.php");
    }

    function ajaxCallback_order_finished()
    {
        var xmlObj = ajaxResponse;
        document.getElementById("shop_done").style.display="block";
        //window["cart_delete"]();  doe not work!, replaced with line below->
            localStorage.setItem('onLine_shoppingCart',null);

        window["cart_loadToView"]();
        $("#toolList").load("../resources/templates/panel_user_list_tool.php");

    }

    //log xml to response in testPage
    function ajaxCallback_std()
    {
        //alert("ajaxCallback_std");
        var respArea = document.getElementById("responseArea");
        respArea.innerHTML += xmlhttp.responseText;
        //document.getElementById("responseRender").innerHTML=xmlhttp.responseText;
    }
    globalAjaxInit = true;





