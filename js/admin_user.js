const objGlobal = {
  "n": "", //name
  "i": "", //id
  "a": "", //access
  "w": "", //workday
  "p": "", //p
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
      break;
    }
  }//for

  //edit box
  var nameBox = document.getElementById("iptName");
  var inputboxID = document.getElementById("iptID");
  var inputboxPwd = document.getElementById("iptPwd");
  if (objGlobal.n == 'Select User') {
    nameBox.value = inputboxID.value = "";
    nameBox.disabled = inputboxID.disabled = inputboxPwd.disabled= true;
  }else{
    if (objGlobal.n == 'addNewUser') {
      nameBox.placeholder = "name of new user";
      nameBox.value = inputboxID.value = inputboxPwd.value = "";
    }else{
      nameBox.value = objGlobal.n;
      inputboxID.value = objGlobal.i;
      inputboxPwd.value = "";
    }
    nameBox.disabled = inputboxID.disabled = inputboxPwd.disabled= false;
  }
  //workday
  elmBtnWorkday = document.getElementsByName("btn_workday");
  for (idx = 0, length = elmBtnWorkday.length; idx < length; idx++) {
    elmBtnWorkday[idx].disabled = (objGlobal.n == 'Select User');
    elmBtnWorkday[idx].checked = (objGlobal.w.includes(elmBtnWorkday[idx].value));
  }
  //access
  elmBtnAccess = document.getElementsByName("btn_access");
  for (idx = 0, length = elmBtnAccess.length; idx < length; idx++) {
    elmBtnAccess[idx].disabled = (objGlobal.n == 'Select User');
    elmBtnAccess[idx].checked = (objGlobal.a.includes(elmBtnAccess[idx].value));
  }
}

//cancel button
function f_refresh() {
  location.reload()
}

//ok button
function f_toConfirm() {
  objGlobal.ni = document.getElementById("iptItem").value;
  elmBtnStorage = document.getElementsByName("btn_storage");
  for (idxStorage = 0, length = elmBtnStorage.length; idxStorage < length; idxStorage++) {
    if (elmBtnStorage[idxStorage].checked) {
      objGlobal.ns = elmBtnStorage[idxStorage].id;
    }//if
  }//for_storage value
  if ((objGlobal.ni == "") || (objGlobal.ns == "")) {
    document.getElementById("lbl_modal").innerHTML = "Create new item";
    document.getElementById("body_modal").innerHTML = "<p class=\"text-danger\">Item name and Storage can not be blank!</p>Press Cancel to return";
    document.getElementById("btn_cancel").style.visibility = "visible";
    document.getElementById("btn_ok").style.visibility = "hidden";
  }else{
    var strToSubmit = "";
    if (objGlobal.i == 'addNewItem') {
      document.getElementById("lbl_modal").innerHTML = "Confirm to create new item?";
      strToSubmit = "Item Category: " + objGlobal.c + "<br>" + "Item name: " + objGlobal.ni + "<br>" + "Item storage location: " + objGlobal.ns;
    }else{
      document.getElementById("lbl_modal").innerHTML = "Confirm to change current item?";
      strToSubmit = "Item Category: " + objGlobal.c + "<br>" + "Item name: " + objGlobal.i + "<br>" + "Item storage location: " + objGlobal.s;
      strToSubmit = strToSubmit + "<br><strong> change to </strong><br>"
      strToSubmit = strToSubmit + "Item Category: " + objGlobal.c + "<br>" + "Item name: " + objGlobal.ni + "<br>" + "Item storage location: " + objGlobal.ns;
    }
    document.getElementById("body_modal").innerHTML = strToSubmit;
    document.getElementById("btn_cancel").style.visibility = "visible";
    document.getElementById("btn_ok").style.visibility = "visible";
  }
  modal_Popup.show();
}

//submit data change
function f_submit() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if (this.responseText == "true") {
      document.getElementById("body_modal").innerHTML = "Submit successfully!<br>Press OK to return";
      document.getElementById("btn_ok").style.visibility = "visible";
      document.getElementById("btn_ok").onclick = f_refresh;
    }else{
      document.getElementById("body_modal").innerHTML = "<p class=\"text-danger\">Update failed!</p>Return code: "+ this.responseText + "<br>Press Cancel to return";
      document.getElementById("btn_cancel").style.visibility = "visible";
      // modal_Popup.hide();
    }
  }
  const strJson = JSON.stringify(objGlobal);
  xhttp.open("POST", "admin_user_update.php");
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(strJson);
  document.getElementById("lbl_modal").innerHTML = "Request submitted";
  document.getElementById("body_modal").innerHTML = "Waiting server response...";
  document.getElementById("btn_cancel").style.visibility = "hidden";
  document.getElementById("btn_ok").style.visibility = "hidden";
}//f_submit
