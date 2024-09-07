<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Log;


class DataTable extends Component
{
    public $items;
    public $columns;
    public $deleteAction;

    public function __construct($items, $columns, $deleteAction)
    {
        $this->items = $items;
        $this->columns = $columns;
        $this->deleteAction = $deleteAction;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.data-table');
    }
}