<x-app-layout>
    <x-slot name="header">
        {{$model->model_display_name}}
    </x-slot>

    <div id="render-section">
        <x-table :info="$data" :model="$model">
        </x-table>
    </div>
    <script> var model = <?php echo json_encode($model->model_name); ?> ; </script>
        <script src="{{ asset('js/crud.js') }}"></script>

        @if ($model->xtraScripts)
            <script src="{{asset($model->xtraScripts)}}"></script>
        @endif
</x-app-layout>
