<ul>
    @foreach ($models as $model)
        <li class="{{ $model->parent_id ? 'ml-10' : '' }}">
            <a href="{{ $model->getUrl() }}">{{ $model->title }}</a>
        </li>
    @endforeach
</ul>
