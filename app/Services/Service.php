<?php

namespace App\Services;


use Eloquent;

class Service extends Eloquent
{
    public function getByColumn(string $column, string|float|int|bool $value)
    {
        $modelName = $this->getModelName();
        $model = new $modelName();

        return $model::where($column, '=', $value)->first();
    }

    protected function getModelName()
    {
        $className = get_class($this);
        return str_replace('Service', '', mb_substr($className, mb_strripos($className, "\\") + 1));
    }



}
