<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $name;
    public $value;
    public $datas;
    public $event;
    public $required;

    public function __construct(
        $label,
        $name,
        $value = "",
        $datas = [],
        $event ="",
        $required =""
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->datas = $datas;
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
        return view('components.form.checkbox');
    }
}
