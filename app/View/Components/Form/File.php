<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class File extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label;
    public $name;
    public $value;
    public $required;
    public $imageOnly;
    public function __construct(
        $label,
        $name,
        $value = "",
        $required="",
        $imageOnly=""
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->imageOnly = $imageOnly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.file');
    }
}
