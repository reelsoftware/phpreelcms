<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryForm extends Component
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

    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $id, $content=null)
    {
        $this->type = $type;
        $this->content = $content;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view("components.$this->type.category-form", [
            'content' => $this->content,
        ]);

    }
}
