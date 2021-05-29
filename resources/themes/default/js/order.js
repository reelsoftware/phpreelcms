'use strict';

let order = 1;

function setOrder(id)
{
    let button = document.getElementById('orderBtn' + id);
    let input = document.getElementById('order' + id);

    if(button.innerHTML == '?')
    {
        button.innerHTML = order;
        input.value = order;
        order++;
    }
}

function resetOrder(total)
{
    let button;
    let input;

    for(let i=0;i<total;i++)
    {
        button = document.getElementById('orderBtn' + i);
        input = document.getElementById('order' + i);

        button.innerHTML = "?";
        input.value = "";
    }

    order = 1;
}