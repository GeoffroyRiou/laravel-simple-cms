<div class="flex flex-col gap-5 md:gap-10">

    <div class="flex flex-col gap-3 md:flex-row md:justify-center">
        <span class="inline-flex gap-2 items-center">
            <x-icon-filter /> <span>|</span> <span>Filtrer :</span>
        </span>
        <div class="flex flex-wrap gap-2">
            <label for="category_all" class="inline-block">
                <input type="radio" id="category_all" name="categoryId" value="0" wire:model.live="categoryId" class="peer hidden" >
                <span class="block peer-checked:bg-dark peer-checked:text-light text-sm bg-white rounded-lg px-4 py-2 cursor-pointer">
                    Toutes
                </span>
            </label>
            @foreach ($categories as $category)
                <label class="inline-block" for="category_{{ $category->id }}">
                    <input type="radio" id="category_{{ $category->id }}" name="categoryId" value="{{ $category->id }}" wire:model.live="categoryId" class="peer hidden">
                    <span class="block peer-checked:bg-dark peer-checked:text-light text-sm bg-white rounded-lg px-4 py-2 cursor-pointer">
                        {{ $category->title }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>
    <div class="flex flex-col gap-5 sm:grid sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($articles as $article)
            <x-articles.article-card :$article />
        @endforeach
    </div>

    @if($articles->links()->paginator->hasMorePages())
        {{ $articles->links(data: ['scrollTo' => false]) }}
    @endif
</div>