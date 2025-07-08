<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageLoader extends Component
{
    public $message, $sizeProgressBar;

    /**
     * Create a new component instance.
     */
    public function __construct($message, $sizeProgressBar)
    {
        $this->message = $message;
        $this->sizeProgressBar = $sizeProgressBar;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-loader');
    }
}
