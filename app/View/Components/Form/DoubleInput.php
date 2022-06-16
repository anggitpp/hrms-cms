<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class DoubleInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $label2;
    public $name;
    public $name2;
    public $value;
    public $value2;
    public $class;
    public $class2;
    public $numeric;

    public function __construct(
        $label,
        $label2,
        $name,
        $name2,
        $value,
        $value2,
        $class = "",
        $class2 = "",
        $numeric = ""
    )
    {
        $this->label = $label;
        $this->label2 = $label2;
        $this->name = $name;
        $this->name2 = $name2;
        $this->value = $value;
        $this->value2 = $value2;
        $this->class = $class;
        $this->class2 = $class2;
        $this->numeric = $numeric;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.double-input');
    }
}
