<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetaDescription extends Component
{
    /**
     * Description value
     *
     * @var string
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.meta-description', [
            'value' => $this->value,
        ]);
    }
}
