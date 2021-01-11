<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\Calendario;

class Calendarios extends \Core\Controller
{
    public function indexAction()
    {
        try 
        {  
            $calendarios = Calendario::obtener_Eventos();
            $eventos="";
            foreach($calendarios as $calendario)
            {
                $eventos .= "{
                    id: '".$calendario['id']."',
                    title: '".$calendario['title']."',
                    start: '".$calendario['start']."',
					end: '".$calendario['end']."',
					color: '".$calendario['color']."',
					description: '".$calendario['descripcion']."',
					desc_ini: '".$calendario['start']."',
					desc_fin: '".$calendario['end']."',
					desc_inih: '".$calendario['hora_inicio']."',
					desc_finh: '".$calendario['hora_final']."'
                    },";
            }

            View::renderTemplate('Calendarios/index.html', [
            'eventos' => $eventos
            ]);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function agregarAction()
    {      
        try 
        {  
            Calendario::$titulo = $_POST['titulo'];
            Calendario::$color = $_POST['color'];
            Calendario::$fecha_inicio = $_POST['fecha_inicio'];
            Calendario::$hora_inicial = $_POST['hora_inicial'];
            Calendario::$fecha_fin = $_POST['fecha_fin']; 
            Calendario::$hora_final = $_POST['hora_final'];
            Calendario::$desc = $_POST['desc'];
            Calendario::agregar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."Calendarios/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

       
}
