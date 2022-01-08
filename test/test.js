var myModal;

window.addEventListener("DOMContentLoaded", function() {
   myModal = new bootstrap.Modal(document.getElementById("RequestModal"));
}, false);

var jsonObj = {
      "s":"VP",
      "c":"Ice Cream",
      "r":1,
      "i1":"C&C",
      "q1":50
};

function f_test () {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
      document.getElementById("srv_msg").innerHTML = this.responseText;
      myModal.hide();
  }
  const strJson = JSON.stringify(jsonObj);
  console.log(strJson);
  xhttp.open("POST", "test.php");
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(strJson);
  document.getElementById("msg").innerHTML = strJson;
}

// function f_test2() {
  // window.location.href = "http://irc.pythonabc.org/mylog.php";
// }

function f_test2() {
  document.getElementById("modal_text").innerHTML = JSON.stringify(jsonObj);
  myModal.show();
}
