<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SelectMonth extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $name;
    public $value;
    public $all;
    public $options;
    public $event;
    public $required;
    public function __construct(
        $label ="",
        $name,
        $value = "",
        $all = "",
        $options = "",
        $event="",
        $required=""
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->all = $all;
        $this->options = $options;
        $this->event = $event;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select-month');
    }
}
