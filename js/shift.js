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
  timestart: "", //start time for part time shift
  timeend: "", //end time for part time shift
  fullday: 0, //full day or part time
  totalmins: 0, //total working minutes
  status: 0 //original status, 0: not working, 1: working. when submit 0: remove (1->0), 1: insert(0->1), 2: update time(1->1)
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
  window.location.href = "shift.php?year=" + newYear.toString() + "&mon=" + newMon.toString();
}

function f_lastMon() {
  if (objGlobal.mon == 1) {
    newYear = objGlobal.year - 1;
    newMon = 12;
  }else{
    newYear = objGlobal.year;
    newMon = objGlobal.mon - 1;
  }
  window.location.href = "shift.php?year=" + newYear.toString() + "&mon=" + newMon.toString();
}

//store selected
function f_storeSelected(idxStore) {
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
  const elmCell = document.getElementById(cellName);
  //highlight cell with border
  const strHighligt = " bg-secondary";
  var strClass = "";
  if ((objGlobal.pstore != "") && (objGlobal.pmday != 0)) {
    strClass = document.getElementById(cellNamePre).getAttribute("class");
    strClass = strClass.replace(strHighligt,""); //remove background from previous selection
    document.getElementById(cellNamePre).setAttribute("class",strClass);
  }
  strClass = elmCell.getAttribute("class");
  strClass = strClass + strHighligt;
  elmCell.setAttribute("class",strClass);

  //post users in the cell to user selection
  if ((objGlobal.userstore == "ALL") || (objGlobal.userstore == objGlobal.store)) {
    objGlobal.status = 0; //not working
    const MaxPpl = elmCell.getAttribute("data-stocking-maxppl");
    for (idxPpl = 1; idxPpl <= MaxPpl; idxPpl++) {
      assignedPpl = document.getElementById(cellName+"_"+idxPpl).innerHTML;
      if (assignedPpl == objGlobal.id) {
        elmPpl = document.getElementById(cellName+"_"+idxPpl);
        objGlobal.status = 1; //working
        break;
      }//fouund
    }//for loop ppl
    document.getElementById("lbl_modal").innerHTML = "Change Shift";
    document.getElementById("lbl_msg").innerHTML = "<strong>" + objGlobal.year + "/" + objGlobal.mon + "/" + objGlobal.mday + "  " + f_weekday(objGlobal.wd) + "</strong>  at  <strong>" + objGlobal.store + "</strong>";
    if (objGlobal.status == 0){ //currently not assigned
      document.getElementById("lbl_Working").innerHTML = "Not working";
      document.getElementById("checkWorking").checked = false;
      document.getElementById("checkFullDay").disabled = document.getElementById("sltTimeStart").disabled = document.getElementById("sltTimeEnd").disabled = true;
    }else{
      document.getElementById("lbl_Working").innerHTML = "Working";
      document.getElementById("checkWorking").checked = true;
      document.getElementById("checkFullDay").disabled = document.getElementById("sltTimeStart").disabled = document.getElementById("sltTimeEnd").disabled = false;
      document.getElementById("checkFullDay").checked = (elmPpl.getAttribute("data-stocking-fullday") == 1);
      document.getElementById("sltTimeStart").value = elmPpl.getAttribute("data-stocking-timestart");
      document.getElementById("sltTimeEnd").value = elmPpl.getAttribute("data-stocking-timeend");
    }
 
    document.getElementById("btn_ok").disabled = false;
    document.getElementById("lbl_status").innerHTML = "";
    modal_Popup.show();
  }else{
    elmUser =  document.getElementById('txtUserName');
    $canChange = elmUser.getAttribute("data-stocking-change");
    if ($canChange == 1) {
      strURL = "shift_admin.php?year=" + objGlobal.year.toString() + "&mon=" + objGlobal.mon.toString() + "&day=" + objGlobal.mday + "&store=" + objGlobal.store + "&cmon=" + document.getElementById("iptDate").getAttribute("data-stocking-mon");
      window.location.href = strURL;
    }else{
      alert ("You are not working in " + objGlobal.store + ".");
    }
  }
}

//Shift data changed.
//intTimeChanged: 1: time change, 0: assignment change
function f_ShiftChanged(intTimeChanged){
  const sltTimeStart = document.getElementById('sltTimeStart');
  const sltTimeEnd = document.getElementById('sltTimeEnd');
  const checkFullDay = document.getElementById('checkFullDay');
  const employeeStatus = document.getElementById("txtUserName").getAttribute("data-stocking-employee");
  //calculate total time
  if (intTimeChanged == 1){ //time change
    if (checkFullDay.checked) { //full day
      objGlobal.fullday = 1;
      objGlobal.timestart = objGlobal.timeend = sltTimeStart.value = sltTimeEnd.value = "0:00";
      sltTimeStart.disabled = sltTimeEnd.disabled = true;
      checkFullDay.disabled = (employeeStatus == "F");
      if (employeeStatus == "P") {
        objGlobal.totalmins = 480; //P employee counts 8 hours
      }else{
        objGlobal.totalmins = 540  //F and S employee counts 9 hours 
      }
    }else{ //part time. 
      objGlobal.fullday = 0;
      objGlobal.timestart = sltTimeStart.value;
      objGlobal.timeend = sltTimeEnd.value;
      const startTime = sltTimeStart.value.split(":");
      const endTime = sltTimeEnd.value.split(":");
      objGlobal.totalmins = (endTime[0] - startTime[0]) * 60 + (endTime[1] - startTime[1]);
      if (objGlobal.totalmins < 0){
        alert("Please choose right time slot.");
        objGlobal.timestart = objGlobal.timeend = sltTimeStart.value = sltTimeEnd.value = "0:00";
        objGlobal.totalmins = 0;        
      }
      sltTimeStart.disabled = sltTimeEnd.disabled = checkFullDay.disabled = false;
    }
  }else{ //assign change. default set to full day
    objGlobal.fullday = 1;
    objGlobal.timestart = objGlobal.timeend = sltTimeStart.value = sltTimeEnd.value = "0:00";
    checkFullDay.checked = true;
    sltTimeStart.disabled = sltTimeEnd.disabled = true;
    if (document.getElementById("checkWorking").checked){
      document.getElementById("lbl_Working").innerHTML = "Working"
      checkFullDay.disabled = (employeeStatus == "F");
      if (employeeStatus == "P") {
        objGlobal.totalmins = 480; //P employee counts 8 hours
      }else{
        objGlobal.totalmins = 540  //F and S employee counts 9 hours 
      }
    }else{
      document.getElementById("lbl_Working").innerHTML = "Not Working"
      checkFullDay.disabled = true;
      objGlobal.totalmins = 0;
    }
  }
}

//submit data change
function f_submit() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if (this.responseText == "true") {
      document.getElementById("lbl_status").innerHTML = "<span class=\"text-primary\">Chang submitted......</span>";
      document.getElementById("body_modal").innerHTML  = "Submit successfully!<br>Press OK to return";
      document.getElementById("btn_ok").setAttribute("onclick","f_refresh()");
      document.getElementById("btn_ok").disabled = false;
      document.getElementById("btn_cancel").disabled = true;
    }else{
      document.getElementById("lbl_status").innerHTML  = "<span class=\"text-danger\">Update failed! " + this.responseText + "</span>";
      document.getElementById("btn_ok").disabled = true;
      document.getElementById("btn_cancel").disabled = false;
    }
  }

  //check data
  var isGoodToSubmit = true;
  const sltTimeStart = document.getElementById('sltTimeStart');
  const sltTimeEnd = document.getElementById('sltTimeEnd');
  const startTime = sltTimeStart.value.split(":");
  const endTime = sltTimeEnd.value.split(":");
  objGlobal.totalmins = (endTime[0] - startTime[0]) * 60 + (endTime[1] - startTime[1]);
  if (objGlobal.totalmins < 0){
    alert("Please choose right time slot.");
    objGlobal.timestart = objGlobal.timeend = sltTimeStart.value = sltTimeEnd.value = "0:00";
    objGlobal.totalmins = 0;
    isGoodToSubmit = false;        
  }else{
    objGlobal.timestart = sltTimeStart.value;
    objGlobal.timeend = sltTimeEnd.value;
  }
  console.log("old status:" + objGlobal.status + " checked:" + document.getElementById("checkWorking").checked);
  if (document.getElementById("checkWorking").checked){
    if (objGlobal.status == 1){ 
      objGlobal.status = 2; //before and after status 1->1, update time
    }else{
      objGlobal.status = 1; //before and after status 0->1, insert
    }
  }else{
    if (objGlobal.status == 1){ 
      objGlobal.status = 0; //before and after status 1->0, remove
    }else{
      objGlobal.status = 0; //before and after status 0->0, no change
      isGoodToSubmit = false;
      alert("No change.");
    }
  }
  console.log("new status:" + objGlobal.status);

  if (isGoodToSubmit){
    const strJson = JSON.stringify(objGlobal);
    xhttp.open("POST", "shift_update.php");
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(strJson);
    document.getElementById("lbl_status").innerHTML = "<span class=\"text-primary\">Chang submitted......</span>";
    document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = true;
  }
}//f_submit
