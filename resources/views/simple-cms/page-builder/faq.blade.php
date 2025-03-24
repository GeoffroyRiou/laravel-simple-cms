@props([
    'questions' => [],
    'title' => '',
    'text' => '',
    'spacer' => '',
])



<section class="{{ $spacer }}">

    <div class="mx-auto px-5 flex flex-col gap-5 xl:max-w-10/12">

        <div class="divide-y divide-indigo-100 rounded-xl border border-indigo-100 bg-white">
            @foreach ($questions as $question)
                <details class="group p-6 [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-indigo-950">
                        <h2 class="text-lg font-medium">{{ $question['title'] }}</h2>

                        <span class="relative size-5 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="absolute inset-0 size-5 opacity-100 group-open:opacity-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="absolute inset-0 size-5 opacity-0 group-open:opacity-100" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </summary>

                    <div class="simple-cms-content mt-4 leading-relaxed text-indigo-800">
                        {!! $question['text'] ?? '' !!}
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
