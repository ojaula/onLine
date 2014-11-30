/**
 * Created by pauldixon on 26/11/14.
 */
var point = {x:0,y:0}
var pointArray = new Array(10);
var mouseDownB = false;
var canvas_element = document.getElementById("myCanvas");
var canvas_context = canvas_element.getContext("2d");

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
    drawing();
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



function drawing()
{
    if ( pointArray[1] != undefined && pointArray[0] != undefined && mouseDownB)
    {
        a = pointArray[1];
        b = pointArray[0];


        if ((a != 0 || y != 0 ) || (a.x != 0 && a.y != 0) || (b.x != 0 && b.y != 0))
        {
            // alert("hello drawing from " + a + " to " +b);

            canvas_context.moveTo(a.x,a.y);
            canvas_context.lineTo(b.x,b.y);
            canvas_context.stroke();





            var  str = new String("DRAWING: (" + a.x + "," + a.y + " to " + b.x + "," + b.y + ")");


            document.getElementById("xycoordinates").innerHTML=str;

        }
    }
}
function cnvs_clearCoordinates()
{
    document.getElementById("xycoordinates").innerHTML="";
    resetMouse();

}