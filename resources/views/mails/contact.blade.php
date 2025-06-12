@if(empty(trim($body)))
    @foreach ($data['fields'] as $label => $value)
        <p>
            <strong>{{$label}} : </strong>
            @if (is_array($value))
            {{ implode(', ', $value) }}
            @else
            {{ $value }}
            @endif
        </p>
    @endforeach
@else
    {!! $body !!}
@endif