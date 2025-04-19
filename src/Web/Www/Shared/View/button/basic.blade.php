<?php declare(strict_types=1); ?>
<button {{$attributes->merge(['class' => $classes, 'type' => 'button', 'style' => 'transition-duration: 50ms;'])}}>
    @if($icon !== null)
        <x-bear::icon class="{{$icon_classes}}" size="{{$icon_size}}" name="{{$icon}}"/>
    @endif
    {{$slot}}
</button>
