const objGlobal = {
  "n": "", //name
  "i": "", //id
  "w": 0, //c_weekday
  "s": "", //store
  "pw": 0,
  "ps": "",
};

arrayToSubmit = []; //arrany pass to admin_shift_save.php
const objDateRange = { //date range object pass to admin_shift_apply.php
  from: "",
  to: ""
}

window.addEventListener("DOMContentLoaded", function() {
  modal_Popup = new bootstrap.Modal(document.getElementById("modal_box"));
}, false);

//cancel button
function f_refresh() {
  location.reload();
}

//return weekday name for Number
function f_weekday(intWD) {
  switch (intWD) {
    case 1:
      return 'Monday';
    case 2:
      return 'Tuesday';
    case 3:
      return 'Wednesday';
    case 4:
      return 'Thursday';
    case 5:
      return 'Friday';
    case 6:
      return 'Saturday';
    case 7:
      return 'Sunday';
  }
}

//highlight selected cell and update user selection
function f_cellSelected(strStore, intWD) {
  objGlobal.ps = objGlobal.s;
  objGlobal.pw = objGlobal.w;
  objGlobal.s = strStore;
  objGlobal.w = intWD;
  const cellName = objGlobal.s + objGlobal.w;
  const cellNamePre = objGlobal.ps + objGlobal.pw;
  //highlight cell with border
  const strBorder = " border border-primary";
  var strClass = "";
  if ((objGlobal.ps != "") && (objGlobal.pw != 0)) {
    strClass = document.getElementById(cellNamePre).getAttribute("class");
    strClass = strClass.replace(strBorder,""); //remove background from previous selection
    document.getElementById(cellNamePre).setAttribute("class",strClass);
  }
  strClass = document.getElementById(cellName).getAttribute("class");
  strClass = strClass + strBorder;
  document.getElementById(cellName).setAttribute("class",strClass);
  document.getElementById("txtSelection").innerHTML = objGlobal.s + "&nbsp;" + f_weekday(objGlobal.w) + "&nbsp;shift:"

  //post users in the cell to user selection
  elmSltItem =  document.getElementById('sltUser');
  var optionItems = elmSltItem.options;
  var pplIdentified = false;
  for (idxOption = 0, lenOption = optionItems.length; idxOption < lenOption; idxOption++) {
    userStore = optionItems[idxOption].getAttribute("data-stocking-userstore");
    if ((objGlobal.s == userStore) || (userStore == "ALL")) {
      optionItems[idxOption].disabled = false; //turn on user option if store matches
      optionID = optionItems[idxOption].value;
      pplIdentified = false;
      for (idxPpl = 1; idxPpl < 4; idxPpl++) {
        assignedPpl = document.getElementById(cellName+idxPpl).innerHTML;
        if (assignedPpl == optionID) {
          pplIdentified = true;
          break;
        }//fouund
      }//for loop ppl
      optionItems[idxOption].selected = pplIdentified;
    }else{
      optionItems[idxOption].disabled = true; //disable user option if UserStore is not matched
    }
  } //for loop user selection
}

//user selection changed
function f_sltUserChanged(){
  if ((objGlobal.s != "") && (objGlobal.w != 0)) {
    document.getElementById('btnSave').disabled = false; //can save now
    elmSltItem =  document.getElementById('sltUser');
    const cellName = objGlobal.s + objGlobal.w;
    var optionItems = elmSltItem.options;
    const strWarning = " text-warning";
    const strDanger = " text-danger";
    idxPpl = 1;
    for (idxOption = 0, lenOption = optionItems.length; idxOption < lenOption; idxOption++) {
      if (optionItems[idxOption].selected) {
        if (idxPpl < 4) { //LIMIT to 3 person per store maximum!!
          elmCell = document.getElementById(cellName+idxPpl);
          workday = optionItems[idxOption].getAttribute("data-stocking-workday");
          strClass = elmCell.getAttribute("class");
          strClass = strClass.replace(strWarning,"");
          strClass = strClass.replace(strDanger,"");
          if (!(workday.includes((objGlobal.w).toString()))) { //off day working
            strClass = strClass + strWarning;
          }
          elmCell.setAttribute("class",strClass);
          document.getElementById(cellName+idxPpl).innerHTML = optionItems[idxOption].value;
        }
        idxPpl++;
      }//if found selected
    } //for loop user selection list
    if (idxPpl > 4) {
      alert("Maximum 3 people allowed per day per store. Some selections are ignored.");
    }else{
      for (;idxPpl < 4; idxPpl++){
        elmCell = document.getElementById(cellName+idxPpl);
        minPpl = Number(elmCell.getAttribute("data-stocking-minppl"));
        strClass = elmCell.getAttribute("class");
        strClass = strClass.replace(strWarning,"");
        strClass = strClass.replace(strDanger,"");
        if (minPpl >= idxPpl) { //lack of ppl
          strClass = strClass + strDanger;
          elmCell.innerHTML = "*";
        }else{
          elmCell.innerHTML = "&nbsp;";
        } // if reach minmum ppl
        elmCell.setAttribute("class",strClass);
      }//for loop to fill in cell to 3 rows
    } //if cell is not filled
  }//if cell is seleted
}

//ok button
function f_toConfirm() {
  class ClassToSubmit {
    constructor (s, w, p){
      this.s = s;
      this.w = w;
      this.p = p;
    }
  }
  idxArray = 0;
  strStore = "";
  elmStores = document.getElementsByName("divStores");
  for (idxStore = 0; idxStore<elmStores.length; idxStore++){
    strStore = elmStores[idxStore].innerText;
    for (idxWD = 1; idxWD < 8; idxWD++) {
      for (idxPpl = 1; idxPpl < 4; idxPpl++) {
        cellName = strStore+idxWD+idxPpl;
        strPpl = document.getElementById(cellName).innerHTML;
        console.log(cellName + " : " + strPpl);
        if ((strPpl != '*') && (strPpl != '&nbsp;')) {
          arrayToSubmit[idxArray] = new ClassToSubmit(strStore,idxWD,strPpl);
          idxArray++;
        }
      }
    }
  }
  document.getElementById("lbl_modal").innerHTML = "Confirm";
  document.getElementById("body_modal").innerHTML = "Save shift tempaltes?";
  document.getElementById("btn_ok").disabled = false;
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
      document.getElementById("btnSave").disabled = false; //turn off save button
    }else{
      document.getElementById("body_modal").innerHTML  = "<p class=\"text-danger\">Update failed!</p>Return code: "+ this.responseText + "<br>Press Cancel to return";
      document.getElementById("btn_ok").disabled = true;
      document.getElementById("btn_cancel").disabled = false;
    }
  }
  const strJson = JSON.stringify(arrayToSubmit);
  xhttp.open("POST", "admin_shift_save.php");
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(strJson);
  document.getElementById("lbl_modal").innerHTML = "Request submitted";
  document.getElementById("body_modal").innerHTML = "Waiting server response...";
  document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = true;
}//f_submit

//confirm to apply shift template to dater range
function f_applyShift() {
  if (document.getElementById("btnSave").disabled) {
    const fromYear = document.getElementById("iptFromYear").value;
    const fromMon = document.getElementById("iptFromMon").value;
    const fromDay = document.getElementById("iptFromDay").value;
    const toYear = document.getElementById("iptToYear").value;
    const toMon = document.getElementById("iptToMon").value;
    const toDay = document.getElementById("iptToDay").value;
    dateFrom = new Date(fromYear, Number(fromMon)-1, fromDay);
    dateTo = new Date(toYear, Number(toMon)-1, toDay); 
    const today = new Date();
    if ((dateFrom > dateTo) || (dateFrom <= today) || (dateFrom == "Invalid Date") || (dateTo == "Invalid Date")) {
      alert ("Date range error! Date must be valid and later than today.");
    }else{
      objDateRange.from = fromYear.toString() + "/" + fromMon + "/" + fromDay;
      objDateRange.to = toYear.toString() + "/" + toMon + "/" + toDay;
      document.getElementById("lbl_modal").innerHTML = "Apply Shift Tempalte";
      document.getElementById("body_modal").innerHTML = "Update shift from " + objDateRange.from + " to " + objDateRange.to + " ?"
      document.getElementById("btn_ok").setAttribute("onclick","f_submitShift()");
      document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = false;
      modal_Popup.show();
    }
  }else{
    alert ("Shift template change is not saved. Save first.")
  }
}

function f_submitShift() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if (this.responseText == "true") {
      document.getElementById("body_modal").innerHTML  = "Submit successfully!<br>Press OK to return";
      document.getElementById("btn_ok").setAttribute("onclick","f_refresh()");
      document.getElementById("btn_ok").disabled = false;
      document.getElementById("btn_cancel").disabled = true;
      document.getElementById("btnSave").disabled = false; //turn off save button
    }else{
      document.getElementById("body_modal").innerHTML  = "<p class=\"text-danger\">Update failed!</p>Return code: "+ this.responseText + "<br>Press Cancel to return";
      document.getElementById("btn_ok").disabled = true;
      document.getElementById("btn_cancel").disabled = false;
    }
  }

  const strJson = JSON.stringify(objDateRange);
  xhttp.open("POST", "admin_shift_apply.php");
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(strJson);
  document.getElementById("lbl_modal").innerHTML = "Request submitted";
  document.getElementById("body_modal").innerHTML = "Waiting server response...";
  document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = true;
}
