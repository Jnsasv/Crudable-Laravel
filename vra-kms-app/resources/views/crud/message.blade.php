<div class="alert alert-{{ $message['kind']??'info' }}" role="alert">
    <h4 class="alert-heading text-center">{{ $message['title']??'' }}</h4>
    <p class="text-center">{{ $message['info']??'' }}</p>
    @isset($message['extrainfo'])
        <hr>
        <p class="text-center"> {{$message['extrainfo']}}</p>
    @endisset

</div>
