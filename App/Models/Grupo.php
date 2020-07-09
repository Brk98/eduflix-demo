<?php

namespace App\Models;

use App\Models\LoginModel;
use PDO;

class Grupo extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT categoria FROM categorias WHERE id=id_categoria) AS categoria FROM grupos WHERE borrado ='0'");
            $stmt->execute([$_SESSION['eduflix']['id']]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtener($id)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM grupos WHERE id=?");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function usuarios($id)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.*, (SELECT role FROM roles WHERE id=id_rol) AS role FROM usuarios, grupos_usuarios WHERE usuarios.id = grupos_usuarios.id_usuario AND grupos_usuarios.id_grupo = ?");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
