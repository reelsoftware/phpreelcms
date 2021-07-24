<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AvailabilityForm extends Component
{
    /**
     * Can be either create or edit depending on the page that renders the component
     * 
     * @var string $type
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view("components.$this->type.availability-form");
    }
}
