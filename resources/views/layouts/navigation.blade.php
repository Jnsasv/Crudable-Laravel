@php
use App\Providers\ModelsProvider;
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="navbar-brand" href="#">
                        <x-application-logo class="" width="30" height="24" />
                    </a>
                </li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav">
                    @php

                        if (count(ModelsProvider::$available_models) == 0) {
                            ModelsProvider::getInstance();
                        }
                    @endphp

                    @if (count(ModelsProvider::$available_models) > 0)
                        <x-dropdown id="crud-dropdown" :active="request()->routeIs('crud.index')" toggle_side='left'>
                            <x-slot name="trigger">
                                Catalogos
                            </x-slot>
                            <x-slot name="content">
                                @foreach (ModelsProvider::$available_models as $key => $item)
                                    @php
                                        $currentmodel = new $item();
                                        $active = request()->route('model') == $key ? 'active' : '';
                                    @endphp
                                    @if ($currentmodel->model_display_name !== '')
                                        <li>
                                            <a class="dropdown-item {{ $active }}"
                                                href="{{ route('crud.index', ['model' => $key]) }}">
                                                {{ $currentmodel->model_display_name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                </ul>

                @endif
            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <x-dropdown id="logout-dropdown" :active="false">
                        <x-slot name="trigger">
                            {{ Auth::user()->name }}
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link class="dropdown-item" :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </ul>
            </div>
        </div>
    </div>
</nav>
