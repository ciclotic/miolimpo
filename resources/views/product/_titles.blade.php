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
<?php $isFirstCategory = true; ?>
@foreach(array_reverse($stack) as $item) @if ($isFirstCategory) <?php $isFirstCategory = false; ?> @else {{ ' - ' }} @endif {{ $item['label'] }} @endforeach
