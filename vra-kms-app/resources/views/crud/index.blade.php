<x-app-layout>
    <x-slot name="header">
        {{$model->model_display_name}}
    </x-slot>

    <div id="render-section">
        <x-table :info="$data" :create="$model->actions['create']" :update="$model->actions['update']" :delete="$model->actions['delete']">
        </x-table>
    </div>

    <script>
        var model = <?php echo json_encode($model->model_name); ?> ;
    </script>
    <script src="{{ asset('js/crud.js') }}"></script>

</x-app-layout>
