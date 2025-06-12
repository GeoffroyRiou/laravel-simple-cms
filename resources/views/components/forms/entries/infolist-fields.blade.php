<dt class="fi-in-entry-wrp-label flex flex-col gap-y-3">


    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
        Réponses au formulaire
    </span>

    <div>
        @php($fieldsData = json_decode($getRecord()->fields))
        @foreach ($fieldsData->fields as $fieldData)
            <p>
                <strong>{{ $fieldData->label }} : </strong>
                @if (is_array($fieldData->value))
                    {{ implode(', ', $fieldData->value) }}
                @else
                    {{ $fieldData->value }}
                @endif
            </p>
        @endforeach
    </div>

</dt>