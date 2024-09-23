<?php

namespace App\Actions;

use App\DTO\Actives\Api\Diagrams\FilterDTO;
use Illuminate\Database\Eloquent\Collection;

class PrepareApiActivesAction
{
    public function handle(Collection|array $actives, FilterDTO $filterDTO)
    {
        $options = [];

        foreach ($actives as $name => $items) {
            $options[] = [
                'name' => $name,
                'value' => collect($items)->sum(fn($active) =>  $active->calculatePrice($active->close)),
            ];
        }

        return $options;
    }

}
