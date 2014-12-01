  //using functions from manager_db
    //----global----
    // Ajax object
    var xmlhttp = new XMLHttpRequest();
    //response feedback display target
    var respArea = document.getElementById("responseArea");

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

            //set callback function -> print php echo on page respone section.
            xmlhttp.onreadystatechange = serverResponseCheck;

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
        xmlhttp.onreadystatechange= serverResponseCheck;

        xmlhttp.open("GET","../resources/libraryDB_manager.php?"+str,true);
        xmlhttp.send();
    }

    // send specific ajax request using get.
    function sendRequest_post(str)
    {
        if (str.length==0)
        {
            return;
        }
        xmlhttp=new XMLHttpRequest(); //create request;
        //set callback function -> print php echo on page respone section.
        xmlhttp.onreadystatechange= serverResponseCheck;

        xmlhttp.open("POST", "../resources/library/DB_manager.php?", true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send(str);
    }

    //server response status check and get request.
    function serverResponseCheck()
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
                handleResponse(xmlhttp);
                respArea.innerHTML += xmlhttp.responseText;
                document.getElementById("responseRender").innerHTML=xmlhttp.responseText;
                respArea.innerHTML+="\nServer is finished!<br>\n";
            }
            else
            {
                alert(xmlhttp.statusText);
            }
        }

    }
    //handle response from ajax
    function handleResponse(xmlhttp){
        //if plaintext -> probably json
        if(xmlhttp.responseText && 0)
        {
            // parse plain text to json.
            try{
                var jsonObj = JSON.parse(xmlhttp.responseText);
                //...
            }
            catch(err){
                console.log("retrieving plain text!");
            }
        }
        // if xml file
        else if(xmlhttp.responseXML)
        {
            try{
               var xmlObj = xmlhttp.responseXML;
                var rootName= xmlObj.documentElement.nodeName;   // get root tag from xml
                var names = xmlObj.getElementsByTagName("POI_namn");
                for (i=0;i<names.length; i++){
                    console.log(names[i].textContent);
                }
                 if(xmlObj.getElementsByTagName('POIs'))
                 {
                //  callback_listAllPOI(xmlObj);
                 }
                

               
            }
            catch(err){
                console.log("Error parsing XML file!");
            }
        }
    }
function xmlProccessSimple(xmlhttp)
{
    var xmlObj = xmlhttp.responseXML;
                var rootName= xmlObj.documentElement.nodeName;   // get root tag from xml
                var names = xmlObj.getElementsByTagName("POI_namn");
                for (i=0;i<names.length; i++){
                    console.log(names[i].textContent);
                }
}
