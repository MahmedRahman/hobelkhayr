<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tableTitle extends Component
{


    public $dataTargetModel;
    public $title;
    public $bntText;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $bntText, $dataTargetModel)
    {
        $this->title = $title;
        $this->bntText = $bntText;
        $this->dataTargetModel = $dataTargetModel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-title');
    }
}