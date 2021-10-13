<?php
namespace App\Http\ViewComposers;

use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ActivityComposer {

    public function compose(View $view){

        $mostCommented = Cache::remember('mostCommented', now()->addMinutes(10), function () {
            return Post::mostCommented()->take(5)->get();
       });
       $mostUsersActive = Cache::remember('mostUserActive', now()->addMinutes(10), function () {
        return User::mostUsersActive()->take(5)->get();
        });
        $mostActiveInLastMonth = Cache::remember('mostActiveInLastMonth', now()->addMinutes(10), function () {
            return User::userActiveInLastMonth()->take(5)->get();
       });
       $view->with([
        'mostCommented' => $mostCommented,
           'mostUsersActive' => $mostUsersActive,
           'userActiveInLastMonth' => $mostActiveInLastMonth
       ]);
    }
}
