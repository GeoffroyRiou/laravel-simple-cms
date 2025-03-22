<form wire:submit="send" class="flex flex-col gap-5 dark:text-light">

    @if ($sendingError || $formSent)
        <div
            class="rounded-lg p-3 {{ $sendingError ? 'bg-red-100 border-red-500 text-red-500' : 'bg-green-100 border-green-500 text-green-500' }}">
            {{ !$formSent ? 'Une erreur est survenue' : 'Votre message a bien été envoyé' }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-5">

        @foreach ($form->fields as $blockIndex => $block)
            <div
                class="flex flex-col gap-2 @error('formData.' . $block['data']['slug']) text-red-500 @enderror {{ $block['data']['fullWidth'] ? 'col-span-full' : '' }}">
                @switch($block['type'])
                    @case('textarea')
                        <label for="{{ $block['data']['slug'] }}"
                            class="text-sm">{{ $block['data']['label'] }}{{ $block['data']['required'] ? '*' : '' }}</label>
                        <textarea id="{{ $block['data']['slug'] }}" wire:model="formData.{{ $block['data']['slug'] }}"
                            class="border border-primary/30 dark:border-transparent dark:bg-light dark:text-dark rounded-lg px-5 py-2 block w-full"></textarea>
                    @break

                    @case('optin')
                        <div class="flex gap-3 @error('formData.' . $block['data']['slug']) -error @enderror">
                            <input id="field_{{ $block['data']['slug'] }}" wire:model="formData.{{ $block['data']['slug'] }}"
                                type="checkbox" value="1" class="field">
                            <label for="field_{{ $block['data']['slug'] }}" class="label">{!! $block['data']['text'] !!}</label>
                        </div>
                    @break

                    @case('choices')
                        <label class="text-sm" for="field_{{ $block['data']['slug'] }}">{{ $block['data']['label'] }}</label>

                        <div class="flex flex-col gap-3 md:flex-row md:flex-wrap">
                            @switch($block['data']['type'])
                                @case('checkbox')
                                @case('radio')
                                    @foreach ($block['data']['values'] as $cle => $valeur)
                                        @php($uniqid = md5(time()) . rand(0, 9999))
                                        <div>
                                            <input :key="{{ 'field_' . $uniqid }}" id="field_{{ $uniqid }}"
                                                wire:model="formData.{{ $block['data']['slug'] }}"
                                                type="{{ $block['data']['type'] ?? 'checkbox' }}" class="border"
                                                value="{{ $cle }}"
                                                @if($block['data']['type'] == 'radio') name="formData.{{ $block['data']['slug'] }}" @endif>
                                            <label :key="{{ 'label_' . $uniqid }}"
                                                for="field_{{ $uniqid }}">{{ $valeur }}{{ $block['data']['required'] ? '*' : '' }}</label>
                                        </div>
                                    @endforeach
                                @break

                                @case('select')
                                    <select wire:model="formData.{{ $block['data']['slug'] }}"
                                        class="border border-primary/30 dark:border-transparent dark:bg-light dark:text-dark rounded-lg px-5 py-2 block w-full"
                                        id="field_{{ $block['data']['slug'] }}">
                                        @foreach ($block['data']['values'] as $cle => $valeur)
                                            <option value="{{ $cle }}">{{ $valeur }}</option>
                                        @endforeach
                                    </select>
                                @break

                                @default
                            @endswitch
                        </div>
                    @break

                    @case('file')
                        <label for="{{ $block['data']['slug'] }}"
                            class="text-sm">{{ $block['data']['label'] }}{{ $block['data']['required'] ? '*' : '' }}</label>
                        <input id="{{ $block['data']['slug'] }}" wire:model="formData.{{ $block['data']['slug'] }}"
                            type="file" class="border border-primary/30 dark:border-transparent dark:bg-light dark:text-dark rounded-lg px-5 py-2 block w-full">
                    @break

                    @default
                        <label for="{{ $block['data']['slug'] }}"
                            class="text-sm">{{ $block['data']['label'] }}{{ $block['data']['required'] ? '*' : '' }}</label>
                        <input id="{{ $block['data']['slug'] }}" wire:model="formData.{{ $block['data']['slug'] }}"
                            type="{{ $block['data']['type'] ?? 'text' }}"
                            class="border border-primary/30 dark:border-transparent dark:bg-light dark:text-dark rounded-lg px-5 py-2 block w-full">
                    @break
                @endswitch
            </div>
        @endforeach
        <div class="col-span-full">
            <button type="submit"
                class="inline-flex items-center justify-between gap-3 rounded-sm px-8 py-3 focus:ring-3 focus:outline-hidden w-fit 
 border border-primary bg-primary text-light hover:bg-transparent hover:text-primary cursor-pointer">
                Envoyer
            </button>
        </div>
    </div>


</form>
