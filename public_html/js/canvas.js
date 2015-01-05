/**
 * Created by pauldixon on 26/11/14.
 */
var point;
var pointArray ;
var mouseDownB;
var canvas_element;
var canvas_context;
var canvas_toolState="1";
var canvas_tools={"1":drawing_line};

var scale; //scale of canvas, 900px is max. rescaling is only needed in x axis.

function canvas_init(){
    point = {x:0,y:0}
    pointArray = new Array(10);
    mouseDownB = false;
    canvas_element = document.getElementById("myCanvas");
    canvas_context = canvas_element.getContext("2d");
    // spacer/holder for canvas coord info tag
    document.getElementById("xycoordinates").innerHTML="Coordinates:(,)";
    scale = (900/canvas_element.offsetWidth);
}

function mouseUp(e)
{
    //cnvs_clearCoordinates();
    resetMouse();
}
function resetMouse()
{

    mouseDownB = false;
    canvas_element.style.cursor = "auto";
    //alert("mouse up");
}
function set_canvas_context(modifyOBJ){
    for (var modProp  in modifyOBJ){
        if (canvas_context.hasOwnProperty(modProp)) {
            canvas_context[modProp] = modifyOBJ[modProp];
        }
        if(modProp=="tool"){
            canvas_toolState = modifyOBJ[modProp];
        }
    }
}

function loadColors(){

}

function mouseDown(e)
{

    //alert("mouse down");
    mouseDownB = true;
    canvas_element.style.cursor = 'none';
    myTimeoutFunction();
}

function myTimeoutFunction()
{
    //alert("myTimeoutFunction")
    storePoints();
    canvas_tools[canvas_toolState]();
    setTimeout(myTimeoutFunction, 1);
}

// this is running indendently and automatically on mouse movement
function cnvs_getCoordinates(evt)
{
    var rect = canvas_element.getBoundingClientRect();
    x= evt.clientX - rect.left;
    y= evt.clientY - rect.top
    point.x = x;
    point.y = y;
    var  str = new String("Coordinates: (" + point.x + "," + point.y + ")");
    if (mouseDownB == false)
    {
        document.getElementById("xycoordinates").innerHTML=str;

    }



}
/* helper method from internet source */
function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: evt.clientX - rect.left,
        y: evt.clientY - rect.top
    };
}

function storePoints()
{
    var localPoint = {x:parseInt(point.x),y:parseInt(point.y)}
    pointArray.pop();
    pointArray.unshift(localPoint);

}


function drawing_line()
{


    if ( pointArray[1] != undefined && pointArray[0] != undefined && mouseDownB)
    {
        a = pointArray[1];
        b = pointArray[0];


        if ((a != 0 || y != 0 ) || (a.x != 0 && a.y != 0) || (b.x != 0 && b.y != 0))
        {
            // alert("hello drawing from " + a + " to " +b);
            scale = (900/canvas_element.offsetWidth);

            canvas_context.moveTo(scale*a.x,a.y);//scale of canvas, 900px is current max. rescaling is only needed in x axis.
            canvas_context.lineTo(scale*b.x,b.y);
            canvas_context.stroke();



            var  str = new String("DRAWING: (" + a.x + "," + a.y + " to " + b.x + "," + b.y + ")");


            document.getElementById("xycoordinates").innerHTML=str;

        }
    }
}

function cnvs_clearCoordinates()
{
    //document.getElementById("xycoordinates").innerHTML="";
    resetMouse();

}