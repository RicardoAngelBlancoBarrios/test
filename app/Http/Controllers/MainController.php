<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\asignacion;
use App\Models\personas;
use App\Models\vw_users;
use App\Models\vw_personas;
use App\Models\vw_tiempoespera;
use App\Models\vw_asignacion;
use App\Models\vw_visualizacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index()
    {
        return view('main.index');
    }

    public function usuarios(){
        $records_usuarios = vw_users::all(); 
        $records_usuarios = json_encode($records_usuarios);
        $records_usuarios = str_replace('"','|', $records_usuarios);
        return view('processes.viewUsuarios', compact('records_usuarios'));
    }

    public function registro_usuarios(Request $request){
        try {
            if($request->hidden_id_user == 0){
                $item_user = new users();
                $item_user->name = $request->nombre_usuario;
                $item_user->full_name = $request->nombre_completo;
                $item_user->password = Hash::make($request->contraseña);
                $item_user->email = $request->correo;
                $item_user->created_at = date('Y-m-d');
                $item_user->updated_at = date('Y-m-d');
                $item_user->email_verified_at = date('Y-m-d');
                $item_user->timestamps = false;
                $item_user->save();
    
                $result['tittle']  = __('Registro realizado');
                $result['type']    = __('success');
                $result['message'] = __('');
                return Redirect::to('usuarios')->with('msg', $result)->withInput();
            }else{
                $item_editar_user = users::find($request->hidden_id_user);
                if($item_editar_user !== null){
                    $item_editar_user->password = Hash::make($request->contraseña);
                    $item_editar_user->created_at = date('Y-m-d');
                    $item_editar_user->updated_at = date('Y-m-d');
                    $item_editar_user->email_verified_at = date('Y-m-d');
                    $item_editar_user->save();

                    $result['tittle']  = __('Registro actualizado');
                    $result['type']    = __('success');
                    $result['message'] = __('');
                    return Redirect::to('usuarios')->with('msg', $result)->withInput();
                }
            }

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = __('Datos duplicados');
            return Redirect::to('usuarios')->with('msg', $result)->withInput();
        }
    }
    public function buscar_usuario(Request $request){
        try {
            $model = vw_users::where('name', $request->nombre_usuario);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('bancos')->with('msg', $result)->withInput();
        }
    }
    public function buscar_correo(Request $request){
        try {
            $model = vw_users::where('email', $request->correo);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('bancos')->with('msg', $result)->withInput();
        }
    }
    public function buscar_edicion_user(Request $request){
        try {
            $model = vw_users::where('id', $request->id);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('bancos')->with('msg', $result)->withInput();
        }
    }

    public function personas(){
        $records = vw_personas::all(); 
        $records = json_encode($records);
        $records = str_replace('"','|', $records);
        return view('processes.viewPersonas', compact('records'));
    }

     public function buscar_edicion_persona(Request $request){
        try {
            $model = vw_personas::where('id', $request->id);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('personas')->with('msg', $result)->withInput();
        }
    }

    public function registro_personas(Request $request){
        try{
            $audit = $this->getAudit();
            if(is_null($request->hidden_id_identificador)){
                $id_persona = $request->hidden_id_identificador;
                $record = personas::where('Identificador', $request->identificador)->get();
                if(count($record) == 0){
                    $item = new personas();
                    $item->Identificador  = $request->identificador;
                    $item->Nombre         = $request->nombre;
                    $item->audit          = $audit;
                    $item->save();

                    $id_persona = $item->id;
                }else{
                    $id_persona = $record[0]->id;
                }
                
                $tiempoespera = vw_tiempoespera::orderBy('tiempoespera', 'asc')->first();
                $idCola = $tiempoespera->idcola;

                $asignacion = vw_asignacion::where('IdPersona', $id_persona)
                ->whereIn('IdStatus', array(14, 15))
                ->get();
                if(count($asignacion) > 0){
                    $result['tittle']  = __('La persona ya tiene una asignación en proceso');
                    $result['type']    = __('error');
                    $result['message'] = __('');
                    return Redirect::to('personas')->with('msg', $result)->withInput();
                }else{
                    $item_asignacion = new asignacion();
                    $item_asignacion->IdPersona     = $id_persona;
                    $item_asignacion->IdCola        = $idCola;
                    $item_asignacion->IdStatus      = 14;
                    $item_asignacion->audit         = $audit;
                    $item_asignacion->save();
                    
                    $result['tittle']  = __('Registro realizado');
                    $result['type']    = __('success');
                    $result['message'] = __('');
                    return Redirect::to('personas')->with('msg', $result)->withInput();
                }

            }else{
                $item = personas::find($request->hidden_id_identificador);
                $item->Identificador  = $request->identificador;
                $item->Nombre         = $request->nombre;
                $item->audit          = $audit;
                $item->save();
    
                $result['tittle']  = __('Registro actualizado');
                $result['type']    = __('success');
                $result['message'] = __('');
                return Redirect::to('personas')->with('msg', $result)->withInput();
            }
        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('personas')->with('msg', $result)->withInput();
        }

    }

    public function visualizacion(){
        return view('processes.viewVisualizacion');
    }

    public function buscar_cola(Request $request){
        try{
            $records = vw_visualizacion::orderBy('IdStatus', 'desc')
            ->orderBy('IdCola', 'asc')
            ->orderBy('IdAsignacion', 'asc')
            ->get(); 
            return $records;
        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('home')->with('msg', $result)->withInput();
        }
    }

    public function actualiza_status_cola(Request $request){
        try{
            DB::table('asignacion')
            ->where('id', $request->id)
            ->update(['IdStatus' => $request->status]);
            
            $result['tittle']  = __('Registro actualizado');
            $result['type']    = __('success');
            $result['message'] = __('');
            return $result;
        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('home')->with('msg', $result)->withInput();
        }
    }
    
}