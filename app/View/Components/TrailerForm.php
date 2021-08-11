<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TrailerForm extends Component
{
    /**
     * Can be either create or edit depending on the page that renders the component
     * 
     * @var string $type
     */
    public $type;

    /**
     * For edit purposes there might be the need to pass content to the component, if left empty it's ignored
     * 
     * @vars $content
     */
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $content=null)
    {
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view("components.$this->type.trailer-form", [
            'trailer' => $this->content,
        ]);
    }
}
