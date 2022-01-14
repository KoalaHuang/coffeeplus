const obj_report = {
  "c": "", //type of orders
  "t": "", //name of type
};

window.addEventListener("DOMContentLoaded", function() {
   const $navbarNav = document.querySelector("#navbarToggler");
   if ($navbarNav) {
     const navbarNavCollapse = (event) => {
       if ($navbarNav != event.target) {
         $navbarNav.setAttribute("class","collapse navbar-collapse");
         document.removeEventListener("mouseup", navbarNavCollapse);
       }
     }

     $navbarNav.addEventListener("shown.bs.collapse", () => {
       document.addEventListener("mouseup", navbarNavCollapse);
     });
   }
}, false);

function f_whichType() {
  elm = document.getElementsByName("btn_ordertype");
  for (i = 0, length = elm.length; i < length; i++) {
    if (elm[i].checked) {
      obj_report.t = elm[i].id;
      obj_report.c = obj_report.t[0].toLowerCase();
      break;
    }
  }
  //update reminding message
  document.getElementById("reminding").innerHTML="Display recent 10 " + obj_report.t + " orders";
  //display item cards
  i = 1;
  elm = document.getElementById("cardType"+i);
  while (elm != null) {
    var rowCat = elm.getAttribute("data-stocking-type");
    if (rowCat == obj_report.c) {
      elm.setAttribute("class","card");
    }else {
      elm.setAttribute("class","card d-none");
    }
    i = i + 1;
    elm = document.getElementById("cardType"+i);
  } // display cards
} //function who_is_requesting
