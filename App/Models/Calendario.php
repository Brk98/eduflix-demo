<?php

namespace App\Models;

use App\Models\LoginModel;
use PDO;

class Calendario extends \Core\Model
{
    public static $titulo;
    public static $color;
    public static $fecha_inicio;
    public static $hora_inicial;
    public static $fecha_fin;
    public static $hora_final;
    public static $desc;


    public static function obtener_Eventos()
    {    
        try 
        {
        $db = static::getDB();
        $sql = "SELECT id, title, start, end, color, descripcion, hora_inicio, hora_final FROM calendario";
        $req = $db->prepare($sql);
        $req->execute();
        $events = $req->fetchAll();

        return $events;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO calendario(title, start, end, color, descripcion, hora_inicio, hora_final) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([self::$titulo, self::$fecha_inicio, self::$fecha_fin, self::$color, self::$desc, self::$hora_inicial, self::$hora_final]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
         

}
