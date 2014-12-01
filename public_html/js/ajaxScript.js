

    //----global----
    // Ajax object
    var xmlhttp = new XMLHttpRequest();
    //response feedback display target
    var respArea = document.getElementById("responseArea");
    //store result
    var ajaxResponse;


    //Bind all buttons from forms to send ajax post message     ($('form[name="sub"]').onsubmit = function(e) {    // ajax dont seem to work.)
    // loop though all elements
    var elems = document.getElementsByTagName('form'), i;
    for (i in elems) {
        elems[i].onsubmit = function (e) {

            //suppress the usual page transfer
            e.preventDefault();

            var f = e.target;
            var formData = new FormData(f); // load all data from form tags
            xmlhttp = new XMLHttpRequest(); //create request;


            //set callback function
            var callback;

            if(f.getAttribute("data-callback")){

                callback = f.getAttribute("data-callback");

            }else{
                callback = "ajaxCallback_std";
            }
            xmlhttp.onreadystatechange= function(){serverResponseCheck(callback);};

            //send te request
            xmlhttp.open("POST", "../resources/library/DB_manager.php?", true);
            xmlhttp.send(formData);
        }
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
        var callback;

        if(f.getAttribute("data-callback")){

            callback = f.getAttribute("data-callback");

        }else{
            callback = "ajaxCallback_std";
        }
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
        var callback;

        if(f.getAttribute("data-callback")){

             callback = f.getAttribute("data-callback");

        }else{
             callback = "ajaxCallback_std";
        }
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
                ajaxResponse = JSON.parse(xmlhttp.responseText);
                window[callback]();
            }
            catch(err){
                console.log("retrieving plain text!");
            }
        }
    }


    function ajaxCallback_items()
    {
        var xmlObj = xmlhttp.responseXML;
        var rootName= xmlObj.documentElement.nodeName;   // get root tag from xml
        var names = xmlObj.getElementsByTagName("item_name");
        for (i=0;i<names.length; i++)
        {
            console.log(names[i].textContent);
        }
    }

    function ajaxCallback_std()
    {
        respArea.innerHTML += xmlhttp.responseText;
        document.getElementById("responseRender").innerHTML=xmlhttp.responseText;
    }


