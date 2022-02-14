/*
JS for shift change by admin
*/
const objGlobal = {
    w: "", //c_weekday
    s: "", //store
    year: "",
    mon: "",
    day: "",
    isholiday: false,
    cmon: "" //calendar month
};

arrayToSubmit = []; //arrany pass to admin_shift_save.php

window.addEventListener("DOMContentLoaded", function() {
    modal_Popup = new bootstrap.Modal(document.getElementById("modal_box"));

    elmCell = document.getElementById("thisCell");
    objGlobal.s = elmCell.getAttribute("data-stocking-store");
    objGlobal.year = elmCell.getAttribute("data-stocking-year");
    objGlobal.mon = elmCell.getAttribute("data-stocking-mon");    
    objGlobal.day = elmCell.getAttribute("data-stocking-day");    
    objGlobal.w = elmCell.getAttribute("data-stocking-weekday");    
    objGlobal.cmon = elmCell.getAttribute("data-stocking-calendarmon"); 
    objGlobal.isholiday = (elmCell.getAttribute("data-stocking-isholiday") == "1"); 
}, false);
  
//return button to return to month calendar displayed
function f_return() {
    strURL = "http://" + window.location.host + "/shift.php?year=" + objGlobal.year + "&mon=" + objGlobal.cmon;
    window.open(strURL,"_self");
}
  
//user selection changed
function f_sltUserChanged(){
    document.getElementById('btnSave').disabled = false; //can save now
    elmSltItem =  document.getElementById('sltUser');
    cellName = objGlobal.s + objGlobal.w;
    var optionItems = elmSltItem.options;
    const strWarning = " text-warning";
    const strDanger = " text-danger";
    var idxPpl = 1;
    for (idxOption = 0, lenOption = optionItems.length; idxOption < lenOption; idxOption++) {
    if (optionItems[idxOption].selected) {
        if (idxPpl < 4) { //LIMIT to 3 person per store maximum!!
        elmCell = document.getElementById(cellName+idxPpl);
        workday = optionItems[idxOption].getAttribute("data-stocking-workday");
        strClass = elmCell.getAttribute("class");
        strClass = strClass.replace(strWarning,"");
        strClass = strClass.replace(strDanger,"");
        if (objGlobal.isholiday) {
            strClass = strClass + strDanger;
        }else{
            if (!(workday.includes(objGlobal.w))) { //off day working
                strClass = strClass + strWarning;
            }
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
}  
//ok button
function f_toConfirm() {
    class ClassToSubmit {
        constructor (store, weekday, id, year, mon, day){
        this.store = store;
        this.weekday = weekday;
        this.id = id;
        this.year = year;
        this.mon = mon;
        this.day = day;
        }
    }
    var idxArray = 0;
    const strStore = objGlobal.s;
    const idxWD = objGlobal.w;
    for (idxPpl = 1; idxPpl < 4; idxPpl++) {
        cellName = strStore+idxWD+idxPpl;
        strPpl = document.getElementById(cellName).innerHTML;
        if ((strPpl != '*') && (strPpl != '&nbsp;')) {
        arrayToSubmit[idxArray] = new ClassToSubmit(strStore,idxWD, strPpl, objGlobal.year, objGlobal.mon, objGlobal.day);
        idxArray++;
        }
    }
    if (idxArray == 0) { //no assignment. return "" id to remove all assignments
        arrayToSubmit[idxArray] = new ClassToSubmit(strStore,idxWD, "", objGlobal.year, objGlobal.mon, objGlobal.day);
    }
    document.getElementById("lbl_modal").innerHTML = "Confirm";
    document.getElementById("body_modal").innerHTML = "Proceed to update this shift?";
    document.getElementById("btn_ok").disabled = false;
    modal_Popup.show();
}
  
//submit data change
function f_submit() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.responseText == "true") {
        document.getElementById("body_modal").innerHTML  = "Submit successfully!<br>Press OK to return";
        document.getElementById("btn_ok").setAttribute("onclick","f_return()");
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
    xhttp.open("POST", "shift_admin_update.php");
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(strJson);
    document.getElementById("lbl_modal").innerHTML = "Request submitted";
    document.getElementById("body_modal").innerHTML = "Waiting server response...";
    document.getElementById("btn_cancel").disabled =  document.getElementById("btn_ok").disabled = true;
}//f_submit