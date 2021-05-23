'use strict';

class Slider
{
    constructor(slide) 
    {
        //Current page that the user is on
        this.page = 0;
        //All the items in the slider
        this.items = document.getElementsByClassName(slide);
        //How many items are at once on the screen
        this.step = 3;
        this.updateStep();
    }

    //Updates the number of items are going to be on the screen based on screen size
    //Calls updateImage() to update the slider
    updateStep()
    {
        let width = window.innerWidth;

        //Check the length of the items to not use a step bigger that the item count
        if(width < 768)
            this.step = 1;
        else if(width < 992 && this.items.length >= 2)
            this.step = 2;
        else if(this.items.length >= 3)
            this.step = 3;
        else
            this.step = this.items.length;        

        //Reset the slider on width update
        this.page = 0;
        
        this.updateImage();
    }

    nextImage() 
    {
        if(this.page == 0)
            this.page = 1;
        else if(this.page == 1)
            this.page = 0;

        if(this.items.length <= this.step)
            this.page = 0;

        this.updateImage();
    }

    prevImage() 
    {
        if(this.page == 0)
            this.page = 1;
        else if(this.page == 1)
            this.page = 0;

        if(this.items.length <= this.step)
            this.page = 0;

        this.updateImage();
    }

    //Sets as block the items that should be displayed
    updateImage() 
    {
        for(let i = 0; i < this.items.length; i++)
        {
            this.items[i].style.display = "none";
            this.items[i].style.animationName = "fadeAnimation";
            this.items[i].style.animationDuration = "1.5s"; 
        }

        for(let i = 0; i < this.step; i++)
        {  
            if(this.items[this.page * this.step + i] != undefined)
                this.items[this.page * this.step + i].style.display = "block";
        }
    }

    
}