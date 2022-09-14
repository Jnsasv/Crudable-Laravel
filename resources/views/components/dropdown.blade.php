@props(['id' => 'dropdown1', 'active'=>false ,'toggle_side'=>"down"])

@php
    switch ($toggle_side) {
        case 'up':
            $toggle = 'dropup';
            break;
        case 'left':
            $toggle = 'dropstart';
            break;
        case 'right':
            $toggle = 'dropend';
            break;
        case 'down':
            $toggle = 'dropdown';
            break;
    }
@endphp
<li class="nav-item {{$toggle}} me-5">
    <a class="nav-link dropdown-toggle {{$active?'active':''}}" href="#" id="{{$id}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      {{$trigger}}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      {{ $content }}
    </ul>
  </li>
