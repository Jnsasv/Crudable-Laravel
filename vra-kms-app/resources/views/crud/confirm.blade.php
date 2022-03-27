<div class="card py-3">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6  col-sm-12 border border-secondary">

                <div class="d-flex flex-row-reverse justify-content-between mt-3">

                    <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Regresar </a>
                    <h4 class="card-title">
                        {{!isset($reactivate)? "Eliminar" : "Re-Activar"}} Registro
                    </h4>
                </div>
                <form class="mt-3" novalidate id="crud-form" action="post">
                    @csrf
                    @if (!isset($reactivate))

                        @if (!$model->create_mode)
                            @method('delete')
                        @endif
                        <h5>¿Estas seguro de querer Eliminar el {{ $model->model_name }}: {{ $model->name }}</h5>
                    @else
                        <h5>¿Estas seguro de querer Re-Activar el {{ $model->model_name }}: {{ $model->name }}</h5>
                        <input type="hidden" name="reactivate" value="true">
                    @endif

                    <div class="d-flex flex-row-reverse mt-4">
                        <a class="btn btn-secondary btn-lg mb-3" href="{{ url()->previous() }}"> Cancelar </a>
                        <input class="btn btn-primary btn-lg mb-3  me-2" type="submit"
                            value="{{ isset($reactivate) ? 'Re-Activar' : 'Eliminar' }}">
                        <input type="hidden" name="id" value=" {{ $model->id }} " />
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
