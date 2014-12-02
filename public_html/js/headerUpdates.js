/**
 * Created by pauldixon on 02/12/14.
 */

function login()
{


    var newHTML = new String('');

    newHTML += '<ul class="nav navbar-nav navbar-right">';
    newHTML += '<li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>';
    newHTML += '<li class="dropdown">';
    newHTML += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Site <span class="caret"></span></a>';
    newHTML += '<ul class="dropdown-menu" role="menu">';
    newHTML += '<li><a href="#">Your details</a></li>';
    newHTML += '<li><a href="#">Your account</a></li>';
    newHTML += '<li class="divider"></li>';
    newHTML += '<li><a href="#">Logout</a></li>';
    newHTML += '</ul>';
    newHTML += '</li>';
    newHTML += ' </ul>';






 //   alert(newHTML);



    document.getElementById('user_section').innerHTML = newHTML;

}
