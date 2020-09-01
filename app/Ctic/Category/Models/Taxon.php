<?php

namespace App\Ctic\Category\Models;

use Vanilo\Framework\Models\Taxon as BaseTaxon;

class Taxon extends BaseTaxon
{
    public function getRouteKeyName()
    {
        return $this->getSlugKeyName();
    }

    public function isInTaxonTree(Taxon $taxon)
    {
        $taxonsTree = '--' . $taxon->id . '-';
        $currentTaxonLevel = $taxon;
        while ($currentTaxonLevel->parent) {
            $taxonsTree .= '-' . $currentTaxonLevel->parent->id . '-';
            $currentTaxonLevel = $currentTaxonLevel->parent;
        }

        return (strpos($taxonsTree, '-' . $this->id . '-')) ? true : false;
    }
}
