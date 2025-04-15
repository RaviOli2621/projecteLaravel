<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class loginIcon extends Component
{
    /**
     * Create a new component instance.
     */

    public $circ;
    public $links;
    public function __construct()
    {
        $nameUs = "";
        $imgUs = "";
        $admin = "false";
        // Si el usuario está autenticado, usar datos de la sesión
        if (Auth::check()) {
            $user = Auth::user();
            $nameUs = $user->Usuari;
            $imgUs = $user->Foto ?? "";
            $admin = $user->Admin ? "true" : "false";
        }
        
        if($nameUs != "")
        {
            if($imgUs !="")
            {
                $circ = '<img id="fotoImg" src="data:image/jpg;base64,'.$imgUs.'" alt="LoginImage">';
            }else
            {
                $circ = '<div><h1>'.substr($nameUs,0,1).'</h1></div>';
            }
            
            // Usar URL absolutas para evitar problemas de redirección
            $links = '<a href="/usuaris/' . $user->Usuari . '/edit">Dades Usuari</a>
            <a href="/logout">Logout</a>';
            
            if($admin == "true") 
            {
                $links .= '<a href="/user/admin">Administrar usuaris</a>';
            }
        }else
        {
            $circ = '<img id="fotoImg" src="/images/noLogin.png" alt="">';
            $links = '<a href="/login">Login</a> <a href="/register">Sign</a>';
        }
        
        $this->circ = $circ;
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.login-icon');
    }
}
