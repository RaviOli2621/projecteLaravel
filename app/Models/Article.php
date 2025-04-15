<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Article extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'articles';

    // Definir la clave primaria
    protected $primaryKey = 'ID';

    // Indicar que la clave primaria es autoincremental
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // No created_at ni updated_at
    public $timestamps = false;

    // Permitir la asignación masiva de estos campos
    protected $fillable = ['Usuari', 'titol', 'cos', 'qr'];

    public static function getAll($perPage = 10)
    {
        return self::paginate($perPage);
    }

    public static function getById($id)
    {
        return self::find($id);
    }
    
    public static function getByUserCorreu($id, $perPage = 10)
    {
        $articles = self::where('Usuari', $id)->paginate($perPage);
        return $articles;
    }
    
    public static function getByContent($titol, $cos)
    {
        $cos = "%".$cos."%";
        $titol = "%".$titol."%";
        return self::where("titol","like",'%'+$titol+'%', "and", "cos","like",'%'+$cos+'%');
    }

    public static function createArticulo($data)
    {
        return self::create([
            'Usuari' => $data['Usuari'],
            'titol' => $data['titol'],
            'cos' => $data['cos'],
            'qr' => $data['qr']
        ]);
    }

    public static function updateTitulo($id, $nuevoTitulo)
    {
        
        $articulo = self::find($id);
        if ($articulo) {
            $articulo->titol = $nuevoTitulo;
            $articulo->save();
            return $articulo;
        }
        return null;
    }
    public static function updateCos($id, $nuevoCos)
    {
        $articulo = self::find($id);
        if ($articulo) {
            $articulo->cos = $nuevoCos;
            $articulo->save();
            return $articulo;
        }
        return null;
    }
    public static function updateQr($id, $nuevoQr)
    {
        $articulo = self::find($id);
        if ($articulo) {
            $articulo->qr = $nuevoQr;
            $articulo->save();
            return $articulo;
        }
        return null;
    }
    public static function updateArticulo($id, $data)
    {
        $articulo = self::find($id);
        if ($articulo) {
            $articulo->titol = $data['titol'];
            $articulo->cos = $data['cos'];
            $articulo->qr = $data['qr']?? '';
            $articulo->save();
            return $articulo;
        }
        return null;
    }
    public static function deleteById($id)
    {
        return self::destroy($id);
    }
}
