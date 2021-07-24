<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkEpisodeToSeasonForm extends Component
{
    /**
     * Variable containing seasons information
     *
     */
    public $seasons;

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
    public function __construct($seasons, $type)
    {
        $this->seasons = $seasons;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view("components.$this->type.link-episode-to-season-form", [
            'seasons' => $this->seasons
        ]);
    }
}
