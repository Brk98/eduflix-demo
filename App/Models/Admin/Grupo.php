<?php

namespace App\Models\Admin;

use PDO;

/**
 * Post model
 *
 */
class Grupo extends \Core\Model
{

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        try {
           
            $db = static::getDB();
            $stmt = $db->query('SELECT id, grupo, descripcion,activo,fechar FROM grupos WHERE borrado = 0 ORDER BY grupo');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
