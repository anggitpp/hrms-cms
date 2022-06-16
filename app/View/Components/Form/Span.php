<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Span extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $name;
    public $value;
    public $file;
    public function __construct($label, $name = "", $value ="", $file ="")
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->file = $file;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.span');
    }
}
