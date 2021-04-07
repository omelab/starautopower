<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category; //for model load


class CategoryComposer {

    public $categoryList = [];

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categoryList = Category::where('parent_id', '=', 0)->where('status', 1)->orderByRaw('-position DESC')->orderBy('position', 'ASC')->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('latestCategory', $this->categoryList);
    }
}	




