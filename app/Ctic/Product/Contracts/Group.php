<?php

namespace App\Ctic\Product\Contracts;

interface Group
{
    /**
     * Returns whether the product is active (based on its state)
     *
     * @return bool
     */
    public function isActive();

    /**
     * Returns the title of the product. If no `title` was given, returns the `name` of the product
     *
     * @return string
     */
    public function title();
}
