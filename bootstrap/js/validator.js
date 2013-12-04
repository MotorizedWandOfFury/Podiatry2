function validateFormData(formid){
    var valid = validateForm(formid);
    if(valid){
        return true;
    } else {
        var confirm = window.confirm("Some questions have not been answered. Submit anyway?");
        if(confirm){
            return true;
        }
    }
    return false;
}

//validation for when patients submit data. This will require them to complete every item.
function validateFormDataPatient(formid){
    var valid = validateForm(formid);
    if(valid){
        return true;
    }
    else {
        alert("Every question must be answered");
        return false;
    }
}

function validateForm(formid){
    var form = document.getElementById(formid);
    var elements = form.elements;
    for(var i = 0; i < elements.length; i++){
        if(elements[i].type == 'checkbox'){
            if(validateCheckbox(elements[i].name) == false){
                return false;
            }
        } else if(elements[i].type == 'radio'){
            if(validateRadio(elements[i].name) == false){
                return false;
            }
        } else if(elements[i].type == 'text'){
            if(validateTextBox(elements[i].name) == false){
                return false;
            }
        } 
    }
    return true;
}

function validateCheckbox(name){
    var elements = document.getElementsByName(name);
    for(var i = 0; i < elements.length; i++){
        if(elements[i].checked){
            console.log("returned true");
            return true;
        }
    }
    console.log("returned false");
        return false;
}

function validateTextBox(name){
    var textBox = document.getElementsByName(name);
    for(var i = 0; i < textBox.length; i++){
        if(textBox[i].value == ''){
            console.log("returned false");
            return false;
        }
    }
    console.log("returned true");
    return true;
    
}

function validateRadio(name){
    var elements = document.getElementsByName(name);
    for(var i = 0; i < elements.length; i++){
        if(elements[i].checked){
            console.log("returned true");
            return true;
        }
    }
    console.log("returned false");
        return false;
}