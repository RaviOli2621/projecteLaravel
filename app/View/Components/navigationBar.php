<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navigationBar extends Component
{
    public $name;
    public $links;
    /**
     * Create a new component instance.
     */
    public function __construct($name)
    {
        if($name != "")
        {
            $links = '<a title="Meus Articles" href="projecte.test/vistaMeusArt.php">Tots</a>
            <a title="Inserir articulo" href="<?php projecte.test/vistaIns.php">Inserir</a>
            <a title="Editar articulos" href="<?php projecte.test/vistaEd.php">Editar</a>
            <a title="Eliminar articulos" href="<?php projecte.test/vistaEl.php">Eliminar</a>';
        }else
        {
            $links = '<a title="Meus Articles" href="<?php projecte.test">Tots</a>
            <a title="Inserir articulo" href="<?php projecte.test">Inserir</a>
            <a title="Editar articulos" href="<?php projecte.test">Editar</a>
            <a title="Eliminar articulos" href="<?php projecte.test">Eliminar</a>';
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
