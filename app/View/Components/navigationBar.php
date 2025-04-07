<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class navigationBar extends Component
{
    public $name;
    public $links;
    /**
     * Create a new component instance.
     */
    public function __construct($name)
    {
        if (Auth::check()) 
        {
            $links = '<a title="Meus Articles" href="' . route('user.articles', Auth::id()) . '">Tots</a>
            <a title="Inserir articulo" href="' . route('articles.create', Auth::id()) . '">Inserir</a>';
        }else
        {
            $links = '<a title="Meus Articles" href="login/">Tots</a>
            <a title="Inserir articulo" href="login/">Inserir</a>
            <a title="Editar articulos" href="login/">Editar</a>
            <a title="Eliminar articulos" href="login/">Eliminar</a>';
        }
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation-bar');
    }
}
