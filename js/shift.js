const objGlobal = {
  name: "",
  id: "",
  userstore: "",
  store: "",
  pstore: "", //previous store
  pmday: 0, //previous day of month
  pmon: 0,
  year: 0,
  mon: 0,
  mday: 0,
  wd: 0, //week day
  istoadd: true
};

window.addEventListener("DOMContentLoaded", function() {
  modal_Popup = new bootstrap.Modal(document.getElementById("modal_box"));

  const elmIptDate = document.getElementById("iptDate");
  objGlobal.year = Number(elmIptDate.getAttribute("data-stocking-year"));
  objGlobal.mon = Number(elmIptDate.getAttribute("data-stocking-mon"));
  
  elmUser =  document.getElementById('txtUserName');
  objGlobal.name = elmUser.innerText;
  objGlobal.id = elmUser.getAttribute("data-stocking-userid");
  objGlobal.userstore = elmUser.getAttribute("data-stocking-userstore");

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

function f_nextMon() {
  if (objGlobal.mon == 12) {
    newYear = objGlobal.year + 1;
    newMon = 1;
  }else{
    newYear = objGlobal.year;
    newMon = objGlobal.mon + 1;
  }
  strURL = "/shift.php?year=" + newYear.toString() + "&mon=" + newMon.toString();;
  window.open(strURL,"_self");
}

function f_lastMon() {
  if (objGlobal.mon == 1) {
    newYear = objGlobal.year - 1;
    newMon = 12;
  }else{
    newYear = objGlobal.year;
    newMon = objGlobal.mon - 1;
  }
  strURL = "/shift.php?year=" + newYear.toString() + "&mon=" + newMon.toString();;
  window.open(strURL,"_self");
}

//store selected
function f_storeSelected(idxStore) {
  console.log("changed");
  const elmStore = document.getElementsByName("divStore"+idxStore);
  var totalDiv = elmStore.length;
  var toDisplay = document.getElementById("btnST"+idxStore).checked;
  for (var idx=0; idx<totalDiv; idx++) {
    var strClass = elmStore[idx].getAttribute("class");
    if (toDisplay) {
      strClass = strClass.replace("d-none","");
    }else{
      strClass = strClass + " d-none";
    }
    elmStore[idx].setAttribute("class",strClass);
  }
}

//highlight selected cell and update user selection
function f_cellSelected(strStore, intWD, intCellYear, intCellMon, intmDay) {
  objGlobal.year = intCellYear;
  objGlobal.pmon = objGlobal.mon;
  objGlobal.mon = intCellMon;
  objGlobal.pmday = objGlobal.mday;
  objGlobal.mday = intmDay;
  objGlobal.pwd = objGlobal.wd;
  objGlobal.wd = intWD;
  objGlobal.pstore = objGlobal.store;
  objGlobal.store = strStore;
  const cellName = objGlobal.store + objGlobal.mon + "_" + objGlobal.mday;
  const cellNamePre = objGlobal.pstore + objGlobal.pmon + "_" + objGlobal.pmday;
  //highlight cell with border
  const strBorder = " border border-primary";
  var strClass = "";
  if ((objGlobal.pstore != "") && (objGlobal.pmday != 0)) {
    strClass = document.getElementById(cellNamePre).getAttribute("class");
    strClass = strClass.replace(strBorder,""); //remove background from previous selection
    document.getElementById(cellNamePre).setAttribute("class",strClass);
  }
  strClass = document.getElementById(cellName).getAttribute("class");
  strClass = strClass + strBorder;
  document.getElementById(cellName).setAttribute("class",strClass);
  console.log("obj: "+objGlobal);
  console.log("cellname: "+cellName);

  //post users in the cell to user selection
  if ((objGlobal.userstore == "ALL") || (objGlobal.userstore == objGlobal.store)) {
    for (idxPpl = 1; idxPpl < 4; idxPpl++) {
      assignedPpl = document.getElementById(cellName+"_"+idxPpl).innerHTML;
      console.log("ppl: " + assignedPpl + " id: " + objGlobal.id);
      if (assignedPpl == objGlobal.id) {
        objGlobal.istoadd = false; //to remove from shift
        break;
      }//fouund
    }//for loop ppl
    document.getElementById("lbl_modal").innerHTML = "Confirm";
    strMsg = objGlobal.year + "/" + objGlobal.mon + "/" + objGlobal.mday + "  " + f_weekday(objGlobal.wd) + "  at  " + objGlobal.store + " store";
    if (objGlobal.istoadd) {
      document.getElementById("body_modal").innerHTML = "Do you want to be <span class=\"text-danger\">added</span> to below shift?<br><br>" + "<strong>" +  strMsg + "</strong>";
    }else{
      document.getElementById("body_modal").innerHTML = "Do you want to be <span class=\"text-danger\">removed</span> from below shift?<br><br>" + "<strong>" + strMsg + "</strong>";
    }
    document.getElementById("btn_ok").disabled = false;
    modal_Popup.show();
  }else{
    alert ("You are not working in " + objGlobal.store + ".");
  }
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
  xhttp.open("POST", "shift_update.php");
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(strJson);
  document.getElementById("lbl_modal").innerHTML = "Request submitted";
  document.getElementById("body_modal").innerHTML = "Waiting server response...";
  document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = true;
}//f_submit
