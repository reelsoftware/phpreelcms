'use strict';

//platformId = where should the resource be saved
//fieldId = what type of resource you are working with (trailer, video)
//edit = true if the page from wich we call the script is an edit page
function switchVideoOption(platformId, fieldId, edit=false) 
{
    let platform = document.getElementById(platformId).value;

    //Define handlers for form fields
    let filedHandler = document.getElementById(fieldId).childNodes[3].childNodes[3];
    let fieldIdHandler = document.getElementById(fieldId).childNodes[1].childNodes[4];

    if(platform == 'html5') 
    {
        document.getElementById(fieldId).childNodes[3].style.display = 'block';
        if(edit == false)
            filedHandler.required = true;

        if(edit == false)
            fieldIdHandler.required = false;
        document.getElementById(fieldId).childNodes[1].style.display = 'none';
    } 
    else 
    {
        if(edit == false)
            filedHandler.required = false;
        document.getElementById(fieldId).childNodes[3].style.display = 'none';

        document.getElementById(fieldId).childNodes[1].style.display = 'block';
        if(edit == false)
            fieldIdHandler.required = true;
    }
}

function updateFileLabel(id) {
    files = document.getElementById(id).value.split('\\');
    file = files[files.length - 1];

    //Update label
    document.getElementById(id).labels[0].textContent = file;
}

function updateAccess()
{
    let accessField = document.getElementById('access');
    let availabilityField = document.getElementById('availability');

    if(availabilityField.value != "1")
        accessField.style.display = 'none';
    else
        accessField.style.display = 'block';

}