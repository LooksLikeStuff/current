<?php

namespace App\View\Composers;

use Illuminate\View\View;

class UserComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();

        return $view->with(['user' => $user]);
    }
}
