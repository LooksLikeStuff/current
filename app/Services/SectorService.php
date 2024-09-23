<?php

namespace App\Services;

use App\DTO\Actives\Api\Diagrams\FilterDTO as DiagramsFilterDTO;
use App\DTO\Sectors\CreateDTO;
use App\Models\Active;
use App\Models\Sector;
use App\Models\User;

class SectorService
{
        function updateOrCreate(CreateDTO $createDTO)
        {
            $uniqueBy = [
                'name' => $createDTO->name,
            ];
            Sector::updateOrCreate($uniqueBy,
            [
               'name' => $createDTO->name,
            ]);
        }

        public function getByName(string $name)
        {
            return Sector::where('name', $name)->first();
        }

        public function  getUserActivesGroupBySector(User $user, DiagramsFilterDTO $filterDTO)
        {
            $actives= $user->actives()
                ->where('date', '<=', $filterDTO->date)
                ->with(['ticker.company.sector', 'prices' => fn($q) => $q->orderByDesc('date')->where('date', '<=', $filterDTO->date)])
                ->get();


            $actives->map(function (Active $active) {
                $active->close = $active->prices->first()->close ?? 0;

                return $active;
            });


            return $actives->groupBy(fn($active) => $active->ticker->company->sector->name);
        }
}
