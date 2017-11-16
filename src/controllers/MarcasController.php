<?php
namespace src\controllers;


use src\controllers\BaseController;

final class MarcasController extends BaseController
{



    public function index($request, $response, $args)
    {
        try {
            $marcas = $this->container->get('MarcasModel');
             return $response->withJson($marcas->getAll(), 200);
        } catch (Exception $e) {
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }

    public function show($request, $response, $args)
    {
        try {
            $marcas = $this->container->get('MarcasModel');
           
           

            if ($data=$marcas->findByIdHash((string)$args['id'])) {
                return $response->withJson($data, 200);
            } else {
                return $response->withJson(array('error'=>'Producto no encontrado'), 404);
            }
        } catch (Exception $e) {
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }

    public function create($request, $response, $args)
    {
        try {
            $inputVars= $request->getParsedBody();
            
            
            if (!isset($inputVars['marca']) or empty($inputVars['marca'])) {
                return $response->withJson(array('error'=>'Parametros vacios o incorrectos - marca'), 400);
            }
            
            if (!isset($inputVars['producto']) or empty($inputVars['producto'])) {
                return $response->withJson(array('error'=>'Parametros vacios o incorrectos - producto'), 400);
            }
            
            if (!isset($inputVars['alternativa']) or empty($inputVars['alternativa'])) {
                return $response->withJson(array('error'=>'Parametros vacios o incorrectos - alternativa'), 400);
            }
            $marcas= $this->container->get('MarcasModel');

             $values=array(
                    "marca" => htmlspecialchars($inputVars['marca']),
                    "producto" => htmlspecialchars($inputVars['producto']),
                    "alternativa" => htmlspecialchars($inputVars['alternativa'])
    
             );
                $data['operacion'] = 'Insercion OK';
                $result=$marcas->insert($values);
                return $response->withJson($data, 201);
        } catch (Exception $e) {
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }

    public function update($request, $response, $args)
    {
        try {
            $inputVars= $request->getParsedBody();
            $values=array();
            if (isset($inputVars['marca']) and !empty($inputVars['marca'])) {
                $values['marca'] = htmlspecialchars($inputVars['marca']) ;
            }
                    
            if (empty($values)) {
                return $response->withJson(array('error'=>'Debe de enviar los campos a modificar.'), 400);
            } else {
                $marcas= $this->container->get('MarcasModel');
                if ($marcas->update($values, (int) $args['id'])) {
                    return $response->withJson(array('operacion'=>'Registro actualizado correctamente'), 200);
                } else {
                    return $response->withJson(array('error'=>'Se ha producido un error en la actualizacion'), 400);
                }
            }
        } catch (Exception $e) {
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }

    public function delete($request, $response, $args)
    {
        try {
            $marcas= $this->container->get('MarcasModel');
            if ($marcas->delete((int) $args['id'])) {
                return $response->withJson(array('operacion'=>'Registro borrado correctamente'), 200);
            } else {
                return $response->withJson(array('error'=>'Se ha producido un error en el borrado.'), 400);
            }
        } catch (Exception $e) {
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }
}
