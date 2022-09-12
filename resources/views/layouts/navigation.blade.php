@php
    use App\Http\Controllers\CrudController;
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
                        {{-- <img src="/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24"> --}}
                        <x-application-logo class="" width="30" height="24" />
                    </a>
                </li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>
                @foreach (CrudController::$available_models as $key=>$item)
                    <x-nav-link :href="route('crud.index',['model'=>$key])" :active="request()->routeIs('crud.index')">
                        {{(new $item())->model_display_name}}
                    </x-nav-link>
                @endforeach
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <x-dropdown align="left">
                        <x-slot name="trigger">
                            {{ Auth::user()->name }}
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link class="dropdown-item" :href="route('logout')" onclick="event.preventDefault();
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
