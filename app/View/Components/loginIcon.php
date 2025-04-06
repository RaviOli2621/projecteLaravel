<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class loginIcon extends Component
{
    /**
     * Create a new component instance.
     */
    public $circ;
    public $links;
    public function __construct($nameUs = "", $imgUs= "", $admin="false")
    {
        if($nameUs != "")
        {
            if($imgUs !="")
            {
                $circ = '<img id="fotoImg" src="data:image/jpg;base64,'.$imgUs.'" alt="LoginImage">';
            }else
            {
                $circ = '<div><h1>'.substr($nameUs,0,1).'</h1></div>';
            }
            $links = '<a href="projecte.test/vistaEdUsuari.php">Dades Usuari</a>
            <form method = "POST" id="LoginForm" action='.htmlentities($_SERVER["PHP_SELF"]).'>
                <input id="LogOut" type="submit" class="logOut" name="LogOut" value="LogOut">
            </form>';
            if($admin == "true") 
            {
                $links .= '<a href="/projecte.test/vistaAdmUsers.php">Administrar usuaris</a>';
            }
        }else
        {
            $circ = '<img src="/images/noLogin.png" alt="">';
            $links = "<a href=./login>Login</a> <a href=./register>Sign</a>'";
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
