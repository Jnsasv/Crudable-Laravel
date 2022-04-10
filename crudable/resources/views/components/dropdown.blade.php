@props(['align' => 'dropdown-menu-start'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'dropleft';
        break;
    case 'right':
    default:
        $alignmentClasses = 'dropright';
        break;
}
@endphp
<li class="nav-item dropdown me-5">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      {{$trigger}}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      {{ $content }}
    </ul>
  </li>
