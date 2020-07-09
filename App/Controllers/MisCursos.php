<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\MisCursosModel;

class MisCursos extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $cursos = MisCursosModel::tabla();
            $ncursos = count($cursos);
            for ($i = 0; $i < $ncursos; $i++)
                $cursos[$i]['descripcion'] = html_entity_decode(strip_tags($cursos[$i]['descripcion']));
            View::renderTemplate('Cursos/tabla.html', [
                'cursos' => $cursos,
                'ncursos' => $ncursos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function cursoAction()
    {      
        try 
        {  
            MisCursosModel::$id = $this->route_params['id'];
            $cursos = MisCursosModel::obtener();
            $grupos = MisCursosModel::grupos();
            for ($i = 0; $i < count($cursos); $i++)
                $cursos[$i]['descripcion'] = strip_tags($cursos[$i]['descripcion']);
            for ($i = 0; $i < count($grupos); $i++)
                $grupos[$i]['descripcion'] = strip_tags($grupos[$i]['descripcion']);
            View::renderTemplate('Cursos/curso.html', [
                'cursos' => $cursos,
                'grupos' => $grupos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
