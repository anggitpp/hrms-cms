<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SelectYear extends Component
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
    public $range;
    public function __construct(
        $label ="",
        $name,
        $value = "",
        $all = "",
        $options = "",
        $event="",
        $required="",
        $range= "5"
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->all = $all;
        $this->options = $options;
        $this->event = $event;
        $this->required = $required;
        $this->range = $range;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select-year');
    }
}
