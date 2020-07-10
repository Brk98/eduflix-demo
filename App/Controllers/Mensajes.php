<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\Mensaje;

class Mensajes extends \Core\Controller
{

   
    public function indexAction()

    {      
        try 
        {  
            $mensajes = Mensaje::index();
            for ($i = 0; $i < count($mensajes); $i++)
            {
                $mensajes[$i]['asunto'] = strip_tags($mensajes[$i]['asunto']);
            }
            View::renderTemplate('Mensajes/index.html', [
                'mensajes' => $mensajes
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function verAction()
    {      
        try 
        {
            $obtenidos = Mensaje::obtener($this->route_params['id']);
            //$mensajes = Mensaje::index();
            for ($i = 0; $i < count($obtenidos); $i++)
            {
                $obtenidos[$i]['descripcion'] = strip_tags($obtenidos[$i]['descripcion']);
            } 
            View::renderTemplate('Mensajes/ver.html', [
                'obtenidos' => $obtenidos
                //'mensajes' => $mensajes
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function verenviadoAction()

    {      
        try 
        {  
            $obtenidos = Mensaje::obtenerR($this->route_params['id']);
            //$mensajes = Mensaje::index();
            for ($i = 0; $i < count($obtenidos); $i++)
            {
                $obtenidos[$i]['descripcion'] = strip_tags($obtenidos[$i]['descripcion']);
            } 
            View::renderTemplate('Mensajes/verenviado.html', [
                'obtenidos' => $obtenidos
                //'mensajes' => $mensajes
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function enviadosAction()

    {      
        try 
        {  
            $mensajes = Mensaje::enviados();
            for ($i = 0; $i < count($mensajes); $i++)
            {
                $mensajes[$i]['asunto'] = strip_tags($mensajes[$i]['asunto']);
            }
            View::renderTemplate('Mensajes/enviados.html', [
                'mensajes' => $mensajes
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function nuevoAction()
    {      
        try 
        {  
            
            View::renderTemplate('Mensajes/nuevo.html', [
        
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } 
    
    public function buscarAction()
    {      
        try 
        {  
            $buscar = $_GET['buscar'];
            $mensajes = Mensaje::buscar($buscar);
            View::renderTemplate('Mensajes/buscar.html', [
                'mensajes' => $mensajes
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function buscarenviadoAction()
    {      
        try 
        {  
            $buscarenviado = $_GET['buscarenviado'];
            $mensajes = Mensaje::buscarenviado($buscarenviado);
            View::renderTemplate('Mensajes/buscarenviado.html', [
                'mensajes' => $mensajes
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function agregarAction()
    {      
        try 
        {  

             $usuarios = preg_split ("/\,/", str_replace(' ', '', $_POST['usuario']));
            
            for ($i = 0; $i < count($usuarios); $i++)
            {
                Mensaje::$ip = $this->getIP();
                $usuario = Mensaje::buscaru($usuarios[$i]);
                Mensaje::agregar($_POST['asunto'], $_POST['descripcion'], $_FILES['archivo']['name'], $usuario[0]['id']);
                $id = Mensaje::obtenerUltimoID();
                $id = $id[0]['id'];
                $dir_subida = "repositorio/mensajes/";
                mkdir($dir_subida.$id."/");
                $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
                move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
                Mensaje::actualizar($id, $_POST['asunto'], $_POST['descripcion'], $_FILES['archivo']['name'], $usuario[0]['id']);
                header( "Location: ".Config::HOST.Config::DIRECTORY."mensajes/enviados");

            } 
           /* echo Mensaje::autocompletar($_POST['usuario'])[0]['usuario'];
           echo $_POST['usuario']; */

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function responderAction()
    {      
        try 
        {   
            $obtenidos = Mensaje::obtener($this->route_params['id']);
            View::renderTemplate('Mensajes/responder.html', [
                'obtenidos' => $obtenidos,
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /* public function responderAction()
    {      
        try 
        {  

                Mensaje::$ip = $this->getIP();
                Mensaje::agregar($_POST['descripcion'], $_FILES['archivo']['name']);
                $id = Mensaje::obtenerUltimoIDPadre();
                $id = $id[0]['padre'];
                $dir_subida = "repositorio/mensajes/";
                mkdir($dir_subida.$id."/");
                $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
                move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
                header( "Location: ".Config::HOST.Config::DIRECTORY."mensajes/enviados");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
     */
    public function descargarAction()
    {      
        try 
        {
            $archivo = Mensaje::obtener($this->route_params['id']);
            $url = Config::HOST.Config::DIRECTORY.'repositorio/mensajes/'.$archivo['0']['id'].'/'.rawurlencode($archivo['0']['archivo']);
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"".$archivo['0']['archivo']."\""); 
            readfile($url);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
