const obj_request = {
  store: "",
  cat: "",
  strSQL: ""
};

function f_who_is_requesting() {
  var elm = document.getElementsByName("btn_store");
  var i = 0;
  //check selected store and category
  for (i = 0, length = elm.length; i < length; i++) {
    if (elm[i].checked) {
      obj_request.store = elm[i].id;
      break;
    }
  }
  elm = document.getElementsByName("btn_cat");
  for (i = 0, length = elm.length; i < length; i++) {
    if (elm[i].checked) {
      obj_request.cat = elm[i].id;
      break;
    }
  }
  //update reminding message
  if (!((obj_request.cat == "") || (obj_request.store == ""))) {
    document.getElementById("reminding").innerHTML="Request " + obj_request.cat + " for " + obj_request.store + " store";

    //display item cards
    i = 1;
    elm = document.getElementById("itemcard"+i);
    while (elm != null) {
      var rowStore = elm.getAttribute("data-stocking-store");
      var rowCat = elm.getAttribute("data-stocking-cat");
      if ((rowCat == obj_request.cat) && (rowStore == obj_request.store))  {
        elm.setAttribute("class","card");
      }else {
        elm.setAttribute("class","card d-none");
      }
      i = i + 1;
      elm = document.getElementById("itemcard"+i);
    } // display cards
    //display submit and clear buttons
    document.getElementById("btn_submit").setAttribute("class","btn btn-primary");
    document.getElementById("btn_clear").setAttribute("class","btn btn-outline-primary");
  } //store and cat seleted
} //function who_is_requesting

function f_refresh() {
  location.reload()
} //function clear()

function f_toConfirm() {
  var i = 1;
  var strToSubmit = "<p>Request for " + obj_request.store + ":</p>";
  var radios, rowStore, rowCat, rowItem;
  var elm = document.getElementById("itemcard"+i);
  while (elm != null) {
    rowStore = elm.getAttribute("data-stocking-store");
    rowCat = elm.getAttribute("data-stocking-cat");
    rowItem = elm.getAttribute("data-stocking-item");
    if ((rowCat == obj_request.cat) && (rowStore == obj_request.store)) {
      radios = document.getElementsByName("reqQty"+i);
      for (var j=0; j<radios.length; j++){
        if (radios[j].checked) {
          strToSubmit = strToSubmit + "<p>" + rowItem + "&nbsp&nbsp[" + radios[j].value + "]</p>";
          break;
        } //if_checked qty
      } //for_search for qty
    } //if_dispolayed row
    i = i + 1;
    elm = document.getElementById("itemcard"+i);
  } // loop rows
  document.getElementById("modal_r_body").innerHTML = strToSubmit;
  model_r.show();
}// function f_toConfirm

function f_submit() {
  model_r.hide();

}//f_submit
