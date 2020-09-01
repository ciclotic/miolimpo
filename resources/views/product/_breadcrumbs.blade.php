<?php
    $stack = [];
    $stack[] = [
        'url'   => route('product.category', [$taxon->slug]),
        'label' => $taxon->name
    ];

    $parent = $taxon;
    while ($parent = $parent->parent) {
        $stack[] = [
            'url'   => route('product.category', [$parent->slug]),
            'label' => $parent->name
        ];
    }
?>
@foreach(array_reverse($stack) as $item)
    <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
@endforeach
