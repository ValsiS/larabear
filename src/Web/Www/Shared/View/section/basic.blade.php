<?php declare(strict_types=1); ?>
<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="{{$headerClasses}}">
        <h3 class="font-semibold">{{$title}}</h3>
    </div>
    {{$slot}}
</div>
