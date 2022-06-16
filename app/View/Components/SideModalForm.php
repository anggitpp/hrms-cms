<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SideModalForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $id;
    public $route;
    public function __construct(
        $title,
        $id="",
        $route=""
    )
    {
        $this->title = $title;
        $this->id = $id;
        $this->routes = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.side-modal-form');
    }
}
