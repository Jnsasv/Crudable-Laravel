<div class="card py-3">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6  col-sm-12 border border-secondary">

                <div class="d-flex flex-row-reverse justify-content-between mt-3">

                    <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Regresar </a>
                    <h5 class="card-title">{{ $model->create_mode ? 'Crear Registro' : 'Actualizar Registro' }}
                    </h5>
                </div>

                <form class="mt-3" novalidate id="crud-form" action="post">
                    @csrf
                    @if (!$model->create_mode)
                        @method('put')
                    @endif
                    <input type="hidden" name="id" value="{{ $model->create_mode ? 0 : $model->id }}" />
                    @foreach ($model->create_mode ? $model->editable_fields : $model->creatable_fields as $key => $item)
                         @php
                            $keys = explode('.', $key);
                        @endphp
                        <div class="mb-3">
                            <label for="{{ count($keys) > 1 ? $keys[0] : $key }}"
                                class="form-label">{{ $item }}</label>

                            @switch($model->field_types[$key])
                                @case('text')
                                    <input name="{{ $key }}" type="text" class="form-control"
                                        id="{{ $key }}" value="{{ $model[$key] }}"
                                        aria-describedby="errors-{{ $keys[0] }}" />
                                @break

                                @case('textarea')
                                    <textarea name="{{ $key }}" class="form-control" id="{{ $key }}" rows="3"
                                        aria-describedby="errors-{{ $keys[0] }}"> {{ $model[$key] }}</textarea>
                                @break

                                @case('select')
                                    <select name="{{ $keys[0] }}" class="form-control" id="{{ $keys[0] }}"
                                        aria-describedby="errors-{{ $keys[0] }}">
                                        <option disabled value="" {{ $model->create_mode ? 'selected' : '' }}>Seleccione una
                                            opción
                                        </option>
                                        @if (count($keys) > 1 && isset($viewBag[$keys[0]]) && $keys[0] != 'status')
                                            @foreach ($viewBag[$keys[0]] as $option)
                                                <option
                                                    {{ !$model->create_mode && $model[$keys[0]]->id == $option->id ? 'selected' : '' }}
                                                    value="{{ $option->id }}">{{ $option->name }}</option>
                                            @endforeach
                                        @elseif($keys[0] == 'status')
                                            <option {{ !$model->create_mode && $model[$keys[0]]->id == 1 ? 'selected' : '' }}
                                                value="1">Activo</option>
                                            <option {{ !$model->create_mode && $model[$keys[0]]->id == 2 ? 'selected' : '' }}
                                                value="2">Inactivo</option>
                                        @endif

                                    </select>

                                    @default
                                @endswitch
                                <div id="errors-{{ $keys[0] }}" class="invalid-feedback"></div>

                            </div>
                        @endforeach


                        <input class="btn btn-primary btn-lg mb-3" type="submit"
                            value="{{ $model->create_mode ? 'Crear' : 'Actualizar' }}">

                    </form>
                </div>
            </div>
        </div>
    </div>
