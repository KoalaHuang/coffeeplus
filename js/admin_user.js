const objGlobal = {
  "n": "", //name
  "i": "", //id
  "a": "", //access
  "w": "", //workday
  "s": "", //store
  "p": "", //p
  "nn": "", //if it's new user. n will be 'addNewUser', nn is the name
  "ni": "",
  "na": "",
  "nw": "",
  "ns": ""
};

window.addEventListener("DOMContentLoaded", function() {
  modal_Popup = new bootstrap.Modal(document.getElementById("modal_box"));
}, false);

//update display with selected user
function f_userSelected () {

  var optionItems = document.getElementById('sltUser').children;
  for (idxOption = 0, lenOption = optionItems.length; idxOption < lenOption; idxOption++) {
    if (optionItems[idxOption].selected) {
      objGlobal.n = optionItems[idxOption].value;
      objGlobal.i = optionItems[idxOption].getAttribute("data-stocking-id");
      objGlobal.a = optionItems[idxOption].getAttribute("data-stocking-access");
      objGlobal.w = optionItems[idxOption].getAttribute("data-stocking-workday");
      objGlobal.s = optionItems[idxOption].getAttribute("data-stocking-userstore");
      break;
    }
  }//for loop to get user data

  //edit box
  var nameBox = document.getElementById("iptName");
  var inputboxID = document.getElementById("iptID");
  var inputboxPwd = document.getElementById("iptPwd");
  if (objGlobal.n == 'Select User') {
    nameBox.value = inputboxID.value = "";
    document.getElementById("btn_toConfirm").disabled = nameBox.disabled = inputboxID.disabled = inputboxPwd.disabled= true;
  }else{
    if (objGlobal.n == 'addNewUser') {
      nameBox.placeholder = "name and ID can't be changed after creation";
      iptPwd.placeholder = "password required for new user";
      nameBox.disabled = inputboxID.disabled = false; //only new user can set name and ID
      nameBox.value = inputboxID.value = inputboxPwd.value = "";
    }else{
      nameBox.disabled = inputboxID.disabled = true; //only new user can set name and ID
      nameBox.value = objGlobal.n;
      inputboxID.value = objGlobal.i;
      inputboxPwd.value = "";
    }
    document.getElementById("btn_toConfirm").disabled = inputboxPwd.disabled= false;
  }
  //workday
  elmBtn = document.getElementsByName("btn_workday");
  for (idx = 0, length = elmBtn.length; idx < length; idx++) {
    elmBtn[idx].disabled = (objGlobal.n == 'Select User');
    elmBtn[idx].checked = (objGlobal.w.includes(elmBtn[idx].value));
  }
  //access
  elmBtn = document.getElementsByName("btn_access");
  for (idx = 0, length = elmBtn.length; idx < length; idx++) {
    elmBtn[idx].disabled = (objGlobal.n == 'Select User');
    elmBtn[idx].checked = (objGlobal.a.includes(elmBtn[idx].value));
  }
  //user store
  elmBtn = document.getElementsByName("btn_store");
  console.log(elmBtn);
  for (idx = 0, length = elmBtn.length; idx < length; idx++) {
    elmBtn[idx].disabled = (objGlobal.n == 'Select User');
    elmBtn[idx].checked = (objGlobal.s == elmBtn[idx].value);
  }
}

//cancel button
function f_refresh() {
  location.reload()
}

//ok button
function f_toConfirm() {
  objGlobal.nn = document.getElementById("iptName").value;
  objGlobal.ni = document.getElementById("iptID").value;
  objGlobal.p = document.getElementById("iptPwd").value;
  elmBtn = document.getElementsByName("btn_access");
  objGlobal.na = "";
  for (idx = 0, length = elmBtn.length; idx < length; idx++) {
    if (elmBtn[idx].checked) {
      objGlobal.na = objGlobal.na + elmBtn[idx].value;
    }//if
  }//Access value
  objGlobal.nw = "";
  elmBtn = document.getElementsByName("btn_workday");
  for (idx = 0, length = elmBtn.length; idx < length; idx++) {
    if (elmBtn[idx].checked) {
      objGlobal.nw = objGlobal.nw + elmBtn[idx].value;
    }//if
  }//workday value
  elmBtn = document.getElementsByName("btn_store");
  for (idx = 0, length = elmBtn.length; idx < length; idx++) {
    if (elmBtn[idx].checked) {
      objGlobal.ns = elmBtn[idx].value;
    }//if
  }//store value
  var strBody = strTitle = "";
  var needToCancel = true;
  if ((objGlobal.ni == "") || (objGlobal.nn == "")) {
    strTitle = "Create new item";
    strBody= "<p class=\"text-danger\">Name and ID can not be blank!</p>Press Cancel to return";
    needToCancel = true;
  }else{
    if (objGlobal.n == 'addNewUser') {
      if (objGlobal.p == '') {
        strTitle = "Create new item";
        strBody = "<p class=\"text-danger\">Password can not be blank!</p>Press Cancel to return";
        needToCancel = true;
      }else{
        strTitle = "Confirm to create new item?";
        strBody = "Name: " + objGlobal.nn + "<br>ID: " + objGlobal.ni + "<br>Workday: " + objGlobal.nw + "<br>Access: " + objGlobal.na + "<br>Store: " + objGlobal.ns + "<br>Password: " + objGlobal.p;
        needToCancel = false;
      }
    }else{
      strTitle = "Confirm to update user?";
      strBody = "Name: " + objGlobal.n + "<br>ID: " + objGlobal.i + "<br>Workday: " + objGlobal.w + "<br>Access: " + objGlobal.a + "<br>Store: " + objGlobal.s;
      strBody = strBody + "<br><strong> change to </strong><br>"
      strBody = strBody + "Name: " + objGlobal.nn + "<br>ID: " + objGlobal.ni + "<br>Workday: " + objGlobal.nw + "<br>Access: " + objGlobal.na + "<br>Store: " + objGlobal.ns;
      if (objGlobal.p != '') {
        strBody = strBody + "<br><span class=\"text-danger\">Password</span>: " + objGlobal.p;
      }
      needToCancel = false;
    }
  }
  document.getElementById("btn_ok").disabled = needToCancel;
  document.getElementById("lbl_modal").innerHTML = strTitle;
  document.getElementById("body_modal").innerHTML = strBody;
  modal_Popup.show();
}

//submit data change
function f_submit() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if (this.responseText == "true") {
      document.getElementById("body_modal").innerHTML  = "Submit successfully!<br>Press OK to return";
      document.getElementById("btn_ok").setAttribute("onclick","f_refresh()");
      document.getElementById("btn_ok").disabled = false;
      document.getElementById("btn_cancel").disabled = true;
    }else{
      document.getElementById("body_modal").innerHTML  = "<p class=\"text-danger\">Update failed!</p>Return code: "+ this.responseText + "<br>Press Cancel to return";
      document.getElementById("btn_ok").disabled = true;
      document.getElementById("btn_cancel").disabled = false;
    }
  }
  const strJson = JSON.stringify(objGlobal);
  xhttp.open("POST", "admin_user_update.php");
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(strJson);
  document.getElementById("lbl_modal").innerHTML = "Request submitted";
  document.getElementById("body_modal").innerHTML = "Waiting server response...";
  document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = true;
}//f_submit
