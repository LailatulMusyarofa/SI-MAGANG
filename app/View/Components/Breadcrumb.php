<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $pageTitle, $currentRoute, $breadcrumbState;

    /**
     * Create a new component instance.
     */
    public function __construct($pageTitle)
    {
        $pageTitle = strtolower($pageTitle);
        $currentRoute = Route::currentRouteName();
        $currentUri = request()->route()->uri;
        $breadcrumbState = '';

        if ($pageTitle == $currentRoute || $pageTitle == $currentUri) $breadcrumbState = 'active';

        $this->pageTitle = strtolower($pageTitle);
        $this->currentRoute = $currentRoute;
        $this->breadcrumbState = $breadcrumbState;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
