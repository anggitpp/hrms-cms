<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $name;
    public $value;
    public $class;
    public $required;
    public $placeholder;
    public $numeric; //USE THIS WHEN INPUT NUMERIC ONLY
    public $currency; //USE THIS WHEN INPUT CURRENCY
    public $nospacing; //USER THIS WHEN INPUT WITHOUT SYMBOL
    public $password; //USER THIS WHEN INPUT PASSWORD

    public function __construct(
        $label="",
        $name,
        $value = "",
        $class = "",
        $required = "",
        $placeholder = "",
        $numeric = "",
        $currency = "",
        $nospacing = "",
        $password =""
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->class = $class;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->numeric = $numeric;
        $this->currency = $currency;
        $this->nospacing = $nospacing;
        $this->password = $password;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
