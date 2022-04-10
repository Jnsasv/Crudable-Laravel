<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $info;
    public $model;
    public $create;
    public $update;
    public $delete;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($info,bool $create, bool $update, bool $delete )
    {
        $this->info = $info;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
        if($this->info->count()>0)
            $this->model = $info[0];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return !empty($this->model) ? view('components.table'): "No hay info para mostrar";
    }
}
