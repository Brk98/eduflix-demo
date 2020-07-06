<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Foro;

class Foros extends \Core\Controller
{
    protected function before()
    {
    }

    public function tablaAction()
    {      
        try 
        {  
            $foros = Foro::tabla();
            for ($i = 0; $i < count($foros); $i++)
                $foros[$i]['descripcion'] = strip_tags($foros[$i]['descripcion']);
            View::renderTemplate('Foros/tabla.html', [
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
            View::renderTemplate('Foros/nuevo.html', [
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
            $elementos = Foro::elemento($this->route_params['id']);
            View::renderTemplate('Foros/editar.html', [
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
            Foro::agregar($_POST['tema'], $_POST['descripcion'], '', $_POST['id_tipo_foro'], isset($_POST['activo']));
            $id = Foro::ultimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/foros/";
            mkdir($dir_subida.$id."/");
            $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
            Foro::actualizar($id, $fichero_subido, $_POST['tema'], $_POST['descripcion'], $_POST['id_tipo_foro'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            $dir_subida = "repositorio/foros/";
            $fichero_subido = $dir_subida .$_POST['id']."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);

            Foro::actualizar($_POST['id'], $fichero_subido, $_POST['tema'], $_POST['descripcion'], $_POST['id_tipo_foro'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Foro::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
