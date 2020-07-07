<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Foro;

class Foros extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $foros = Foro::tabla();
            for ($i = 0; $i < count($foros); $i++)
                $foros[$i]['descripcion'] = strip_tags($foros[$i]['descripcion']);
            View::renderTemplate('Admin/Foros/tabla.html', [
                'foros' => $foros
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            $foros = Foro::tabla();
            $tipos = Foro::tipo();
            View::renderTemplate('Admin/Foros/nuevo.html', [
                'foros' => $foros,
                'tipos' => $tipos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $foros = Foro::tabla();
            $tipos = Foro::tipo();
            $elementos = Foro::obtener($this->route_params['id']);
            View::renderTemplate('Admin/Foros/editar.html', [
                'elementos' => $elementos,
                'foros' => $foros,
                'tipos' => $tipos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {  
            Foro::$ip = $this->getIP();
            Foro::agregar($_POST['tema'], $_POST['descripcion'], '', $_POST['id_tipo_foro'], isset($_POST['activo']));
            $id = Foro::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/foros/";
            mkdir($dir_subida.$id."/");
            $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
            Foro::actualizar($id, $fichero_subido, $_POST['tema'], $_POST['descripcion'], $_POST['id_tipo_foro'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Foro::$ip = $this->getIP();
            $dir_subida = "repositorio/foros/";
            $fichero_subido = $dir_subida .$_POST['id']."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);

            Foro::actualizar($_POST['id'], $fichero_subido, $_POST['tema'], $_POST['descripcion'], $_POST['id_tipo_foro'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Foro::$ip = $this->getIP();
            Foro::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
