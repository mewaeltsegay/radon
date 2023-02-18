/**
 * Created by NCEW on 5/7/2020.
 */
function pic(value) {
    alert(value);
}

function getAllItems(){
    var xhttp = new XMLHttpRequest();
    var jsonn = "";
    var arr = [];
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonn = JSON.parse(this.responseText);
            var x;
            for (x = 0;x <= jsonn.length - 1;x++){
                arr.push(jsonn[x]);
            }
        }
    };
    xhttp.open("GET", "items/getAllItems.php", true);
    xhttp.send();

    return arr;
}

function setQuantity(input) {
    if(input !== ''){
        $('#quantity').attr('max',1).attr('min',1);
    }
    else{
        document.getElementById('quantity').removeAttribute('max').removeAttribute('min');
    }
}

function getItemInfo(name) {
    var xhttp = new XMLHttpRequest();
    var jsonn = "";
    var arr = [];
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonn = JSON.parse(this.responseText);
            if(jsonn.item != "empty") {
                document.getElementById("type").value = jsonn["type"];
                document.getElementById("manufacturer").value = jsonn["manufacturer"];
                document.getElementById("description").value = jsonn["description"];
                document.getElementById("category").value = jsonn["category"];
                document.getElementById("location").value = jsonn["location"];
                document.getElementById("model").value = jsonn["model"];
                document.getElementById("serialno").value = jsonn["serial_no"];
                document.getElementById("supplier").value = jsonn["supplier"];
                document.getElementById("reorderlevel").value = jsonn["reorder_level"];
                document.getElementById("target").value = jsonn["target_stock_level"];
                if (jsonn.discontinued == "Y") {
                    document.getElementById("discontinued").setAttribute("checked", "checked");
                }
                else {
                    document.getElementById("discontinued").removeAttribute("checked");
                }
                document.getElementById("price").value = jsonn["unit_price"];
                document.getElementById("measure").options.namedItem(jsonn["unit_measure"]).selected = true;
                document.getElementById("stock").value = jsonn["quantity"];
                if (jsonn["expiry_date"] != "0000-00-00") {
                    document.getElementById("expire").value = jsonn["expiry_date"];
                }
                else {
                    document.getElementById("expire").value = "";
                }
                if (jsonn.picture != "" && jsonn.picture != undefined) {
                    $('#icon').attr('hidden',true);
                    $('#pic').attr('src','Items/images/'+ jsonn.picture + '.jpg' ).attr('hidden',false);
                    $('#browse').attr('value',jsonn.picture);
                    // document.getElementById("image").innerHTML = '<div><label>Image</label><img class="img-center card-img-top border rounded" src="Items/images/' + jsonn.picture + '.jpg"><input type="text" hidden name="image" value="'+jsonn.picture+'"></div>'
                }
            }
            else{
                document.getElementById("manufacturer").value = '';
                document.getElementById("description").value = '';
                document.getElementById("category").options.item(0).selected = true;
                document.getElementById("location").options.item(0).selected = true;
                document.getElementById("type").options.item(0).selected = true;
                document.getElementById("model").value = '';
                document.getElementById("serialno").value = '';
                document.getElementById("supplier").value = '';
                document.getElementById("reorderlevel").value = '';
                document.getElementById("target").value = '';
                document.getElementById("discontinued").removeAttribute("checked");
                document.getElementById("price").value = '';
                document.getElementById("measure").options.item(0).selected = true;
                document.getElementById("quantity").value = '';
                document.getElementById("expire").value = "";
                document.getElementById("stock").value = "";
                // document.getElementById("image").innerHTML = '<div class="form-group"><label>Image</label><div class="img-center card-img-top text-center border rounded"><i class="fas fa-camera pt-6 pb-6" style="font-size: 72pt"></i> </div><input class="pt-1" name="image" id="browse" type="file" style="width: 240pt;overflow: hidden;text-overflow: clip"></div>'
                $('#icon').attr('hidden',false);
                $('#pic').attr('src','#' ).attr('hidden',true);
                $('#browse').attr('value','');
            }
        }
    };
    xhttp.open("GET", "items/getItemData.php?item="+name, true);
    xhttp.send();
}

function getInStock(name) {
    var xhttp = new XMLHttpRequest();
    var jsonn = "";
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonn = JSON.parse(this.responseText);
           document.getElementById("in_stock").value = jsonn.instock;
           document.getElementById("quantity").setAttribute("max",jsonn.instock);
           if(jsonn.unit === "pcs"){
               document.getElementById("quantity").setAttribute("readonly", "readonly");
               document.getElementById("quantity").removeAttribute("step");
               document.getElementById("items").setAttribute("multiple","multiple");
           }
           else {
               document.getElementById("quantity").removeAttribute("readonly");
               document.getElementById("quantity").setAttribute("step","any");
               document.getElementById("items").removeAttribute("multiple");
           }
        }
    };
    xhttp.open("GET", "items/getInStock.php?item="+name, true);
    xhttp.send();

}

function getIndvItem(name) {
    var type ="";

    if(document.getElementById("transaction_type").value == "Relocate"){
    type = '&type=relocate';
    }
    var xhttp = new XMLHttpRequest();
    var jsonn = "";
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonn = JSON.parse(this.responseText);
            txt = '<option selected="selected" disabled="disabled">Select an Item</option>';
            var i = 0;
            if(document.getElementById("transaction_type").value == "Relocate") {
                for (i in jsonn["content"]) {
                    txt += '<option>' + jsonn["content"][i]["data"] + ' (' + jsonn["content"][i]["location"] + ')' + '</option>';
                }
            }
            else {
                for (i in jsonn["content"]) {
                    txt += '<option>' + jsonn["content"][i]["data"] + '</option>';
                }
            }
            document.getElementById("items").innerHTML = txt;
            document.getElementById("quantity").value = '';
        }
    };
    xhttp.open("GET", "items/getIndividualItemStock.php?name="+name+type, true);
    xhttp.send();

}

function loadTable(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("table").innerHTML = this.responseText;
            $(".loader").hide();
        }
    };
    xhttp.open("GET", "handleCSV.php", true);
    xhttp.send();
}

function getEmployees() {
    var xhttp = new XMLHttpRequest();
    var jsonn = "";
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonn = JSON.parse(this.responseText);
            txt = '<option selected="selected" disabled="disabled">Select an Employee</option>';
            var i = 0;
            for(i in jsonn["content"]){
                txt += '<option>'+jsonn["content"][i]["name"]+'</option>';
            }
            document.getElementById("employee").innerHTML = txt;
        }
    };
    xhttp.open("GET", "employees/getEmployees.php", true);
    xhttp.send();
}

function setImageModalSRC(image){
    $("#imageModalContent").attr("src","items/images/"+image+".jpg");
    document.getElementById('imageModal').click();
}

// function quantityControl(value) {
//     if(value > document.getElementById("in_stock").value){
//         alert("Quantity exceeds what's in stock. ");
//     }
// }
function preview(input) {
    if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function (e){
            $('#pic').attr('hidden',false);
            $('#pic').attr('src',e.target.result);
            $('#icon').attr('hidden',true);
        }

        reader.readAsDataURL(input.files[0]);
    }

}
function deleteUser(id) {
    var xhttp = new XMLHttpRequest();
    var jsonn = "";
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonn = JSON.parse(this.responseText);
            if(jsonn["success"] === true) {
                document.getElementById(id).setAttribute("hidden", "hidden");
            }
            else{
                alert("Something went wrong. Try again.");
            }
        }
    };
    xhttp.open("GET", "users/deleteUser.php?id="+id, true);
    xhttp.send();
}
function showAssignedTo(){
    var type = document.querySelector("#type").value

    if(type == "Fixed Asset"){
        document.querySelector("#rowAssignedTo").removeAttribute("hidden")
        document.querySelector("#assigned_to").removeAttribute("disabled")
    }
    else{
        document.querySelector("#rowAssignedTo").setAttribute("hidden","hidden")
        document.querySelector("#assigned_to").setAttribute("disabled","disabled")
    }
}
function assetFilter() {
    // Declare variables
    var input,input2,input3, filter,filter2,filter3, table, tr, td,td2,td3, i, txtValue,txtValue2,txtValue3;
    input = document.getElementById("loc");
    input2 = document.getElementById("cat");
    input3 = document.getElementById("emps");
    filter = input.value.toUpperCase();
    filter2 = input2.value.toUpperCase();
    filter3 = input3.value.toUpperCase();
    table = document.getElementById("assets");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[1];
        td3 = tr[i].getElementsByTagName("td")[5];
        if (td) {
            txtValue = td.textContent || td.innerText;
            txtValue2 = td2.textContent || td2.innerText;
            txtValue3 = td3.textContent || td3.innerText;
            if ((txtValue.toUpperCase().indexOf(filter) > -1 || filter === 'ANY') && (txtValue2.toUpperCase().indexOf(filter2) > -1 || filter2 === 'ANY') && (txtValue3.toUpperCase().indexOf(filter3) > -1 || filter3 === 'ANY')) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function Quantity(){
    document.getElementById("quantity").value = $('#items option:selected').length;
}
function SIVShow(transactionType){
    if(transactionType === "Loan"){
        document.getElementById("siv").setAttribute("disabled","disabled");
    }
    else{
        document.getElementById("siv").removeAttribute("disabled");
    }
    if(transactionType === "Permanently Move" || transactionType === "Relocate"){
        document.getElementById('loc-row').removeAttribute("hidden");
        document.getElementById('location').setAttribute("required","required");
    }
    else{
        document.getElementById('loc-row').setAttribute("hidden","hidden");
        document.getElementById('location').removeAttribute("required");
    }
}

function populateItemsList(transactionType){
    var type = "";
    if (transactionType === 'Relocate'){
        type = 'fixed asset';
    }
    else {
        type = 'inventory';
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
           document.getElementById('item').innerHTML = "<option selected=\"selected\" disabled=\"disabled\">Select an Item</option>"+this.responseText;
        }
    };
    xhttp.open("GET", "items/populateItemsList.php?type="+type, true);
    xhttp.send();

}

function transin(){
   $('#radon').attr('hidden',true);
}

function transout(){
    $('#radon').attr('hidden',false);
}
function confirmpasswords() {
    var newpass = document.getElementById("new").value;
    var confirm = document.getElementById("confirm").value;

    if(newpass == confirm){
        return true;
    }
    else{
        alert("New Passwords don't match.");
        return false;
    }
}

function confirmpasswords2() {
    var newpass = document.getElementById("pass").value;
    var confirm = document.getElementById("pass2").value;

    if(newpass == confirm){
        return true;
    }
    else{
        alert("Passwords don't match.");
        return false;
    }
}

function confirmpasswords3() {
    var newpass = document.getElementById("pass1").value;
    var confirm = document.getElementById("pass12").value;

    if(newpass == confirm){
        return true;
    }
    else{
        alert("Passwords don't match.");
        return false;
    }
}

function setDamaged(id,uuid,qty,type){
    location.assign("items/damaged.php?id="+id+"&uuid="+uuid+"&qty="+qty+"&type="+type);
}

function selector(item,cat,loc){
    $("#item").children("#"+item).attr("selected",true);
    $("#category").children("#"+cat).attr("selected",true);
    $("#location").children("#"+loc).attr("selected",true);
}
function enlarge(id) {
    document.getElementById(id).style.width = "100pt";
    document.getElementById(id).style.height = "100pt";
}

function resizeBAck(id) {
    document.getElementById(id).style.width = "40pt";
    document.getElementById(id).style.height = "40pt";
}
function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value.trim();
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                     (or any other open lists of autocompleted values:*/
                    closeAllLists();
                    getItemInfo(inp.value);
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
             increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
             decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
         except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
    /*execute a function when the document loses focus:*/
    inp.addEventListener("focusout", function (e) {
        closeAllLists(e.target);
    });
}

