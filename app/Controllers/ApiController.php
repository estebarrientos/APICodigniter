<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    protected $modelName = 'App\Models\AnimalModelo';
    protected $format    = 'json';

    public function index(){
        return $this->respond($this->model->findAll());
    }
    public function buscarAnimal($id){
        return $this->respond($this->model->find($id));
    }

    public function agregarAnimal(){

        $idAnimal =$this->request->getPost('idAnimal');
        $nombreAnimal = $this->request->getPost('nombreAnimal');
        $edad = $this->request->getPost('edad');
        $tipoAnimal = $this->request->getPost('tipoAnimal');
        $descripcion = $this->request->getPost('descripcion');
        $comida = $this->request->getPost('comida');

        $datosEnvio = array(
            "idAnimal"=>$idAnimal,
            "nombreAnimal"=>$nombreAnimal,
            "edad"=>$edad,
            "tipoAnimal"=>$tipoAnimal,
            "descripcion"=>$descripcion,
            "comida"=>$comida
        );

        if($this->validate('animales')){
            $this->model->insert($datosEnvio);
            $mensaje = array('estado'=>true, 'mensaje'=>"registro agregado con exito");
            return $this->respond($mensaje);

        }else{
            $validation = \config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


        


    }

    public function editarAnimal($id){
        $datosPeticion = $this->request->getRawInput();
        
        $idAnimal=$datosPeticion["idAnimal"];
        $nombreAnimal =$datosPeticion["nombreAnimal"];

        $datosEnvio = array(
            "idAnimal"=>$idAnimal,
            "nombreAnimal"=>$nombreAnimal

        );

        if($this->validate('animalesPut')){
            $this->model->update($id,$datosEnvio);
            $mensaje = array('estado'=>true, 'mensaje'=>"registro Editado con éxito");
            return $this->respond($mensaje);


        }else{

            $validation = \config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }




    }

    public function eliminarAnimal($id){

        $consulta=$this->model->where('idAnimal',$id)->delete();
        $filasAfectadas =$consulta->connID->affected_rows;

        if($filasAfectadas==1){
            $mensaje= array('estado'=>true, 'mensaje'=>"El animal ha sido eliminado correctamente");
            return $this->respond($mensaje);

        }else{
            $mensaje= array('estado'=>false, 'mensaje'=>"El animal no ha sido encontrado en nuestros registros");
            return $this->respond($mensaje,400);

        }







    }



    
}