<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class DateTimePicker extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $name;
    public $name2;
    public $value;
    public $value2;
    public $class;
    public $required;
    public function __construct(
        $label,
        $name,
        $name2,
        $value = "",
        $value2 = "",
        $class = "",
        $required = ""
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->name2 = $name2;
        $this->value = $value;
        $this->value2 = $value2;
        $this->class = $class;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.date-time-picker');
    }
}
