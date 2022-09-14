<?php

namespace App\View\Components;

use App\Models\Crudable;
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
    public function __construct($info,Crudable $model )
    {
        $this->info = $info;
        $this->create = in_array('create', $model->actions);
        $this->update = in_array('update', $model->actions);
        $this->delete = in_array('delete', $model->actions);
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return  view('components.table');
    }
}
