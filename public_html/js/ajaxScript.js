

    //----global----
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
        f =document.getElementById("get_items");
        var callback = f.getAttribute("data-callback")|| "ajaxCallback_std";

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
                console.log("retrieving plain text!");
            }
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
        var item_image  = xmlObj.getElementsByTagName("item_image");
        var item_category  = xmlObj.getElementsByTagName("category_id");

        for (var i=0;i<item_name.length; i++)
        {
            //no callbacks for now, calculate price on serverside
            //onsubmit="function(e){formSubmitEvent(e);}"
            var form =''+
                '<form  id="form_insert_orderDetail" action="../resources/manage_db.php" method="get">'+
                    '<input type="hidden" type="text" name="action" value="insert_orderDetail">'+
                    '<input type="hidden" type="text" name="name" value="1">'+
                    'QTY:'+
                    '<input type="text" maxlength="1" size="2" name="quantity" value="1">'+
                    '<button type="submit">BUY</button>'+
                '</form>';

            // check if if item is a color
            if (item_category[i].textContent==2){}
            var thumnail = '' +
                '<div style="display: inline-block; max-height=40px; max-width=50px;" class="thumbnail">'+
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
            var headerDeployDiv = document.getElementById("header_userSection");

            //fetch html with Ajax, not async!.
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","../resources/templates/header_hasLoggedin.php", false);
            xmlhttp.send();
            headerDeployDiv.innerHTML = xmlhttp.responseText;


        }

        //change header bar
        //change shop bar

    }



    //log xml to response in testPage
    function ajaxCallback_std()
    {
        var respArea = document.getElementById("responseArea");
        respArea.innerHTML += xmlhttp.responseText;
        document.getElementById("responseRender").innerHTML=xmlhttp.responseText;
    }





