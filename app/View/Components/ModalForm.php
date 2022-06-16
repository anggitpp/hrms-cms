<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $size;
    public function __construct($title = "Form Data", $size = "")
    {
        $this->title = $title;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-form');
    }
}
