<dt class="fi-in-entry-wrp-label flex flex-col gap-y-3">


    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
        Réponses au formulaire
    </span>

    <div>
        @php($fieldsData = json_decode($getRecord()->fields))
        @foreach ($fieldsData->fields as $label => $value)
            <p>
                <strong>{{ $label }} : </strong>
                @if (is_array($value))
                    {{ implode(', ', $value) }}
                @else
                    {{ $value }}
                @endif
            </p>
        @endforeach
    </div>

</dt>