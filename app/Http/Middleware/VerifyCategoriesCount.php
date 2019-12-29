<?php

namespace App\Http\Middleware;

use App\Category;
use Closure;

class VerifyCategoriesCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if there is no categories at all redirect back
        if(Category::all()->count() == 0){
            session()->flash('error','You need to add a category first !');
            return redirect('/categories');
        }
        else    
        return $next($request);
    }
}
