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
