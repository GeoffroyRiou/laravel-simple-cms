@php($languagesAvailable = config('app.locales'))

@if (count($languagesAvailable) > 1)
    <form action="{{ route('language.switch') }}" method="post">
        @csrf
        <select name="locale" onchange="this.form.submit()">
            @foreach ($languagesAvailable as $language)
                <option value="{{ $language }}" {{ app()->getLocale() === $language ? 'selected' : '' }}>
                    {{ $language }}</option>
            @endforeach
        </select>
    </form>
@endif
