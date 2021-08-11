<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubmitForm extends Component
{
    /**
     * Name of the submit button
     * 
     * @var string $name
     */
    public $buttonName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($buttonName)
    {
        $this->buttonName = $buttonName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.submit-form', [
            'buttonName' => $this->buttonName
        ]);
    }
}
