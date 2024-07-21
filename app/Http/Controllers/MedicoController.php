<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Exame;
use App\Models\Medico;
use App\Models\User;
use App\Models\Utente;
use App\Notifications\DataAlterada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gerir_utentes()
    {
        if(Auth::check()){
            if(Auth::user()->Nivel === 1){
                 
                    $medico = Medico::where('id_usuario',Auth::user()->id_usuario)->first();
                    $consultas = DB::table('utentes')->join('consultas','utentes.id_utente','=','consultas.id_utente')->where('id_medico',$medico->id_medico)->get();
                
                 
               return view('medicos.dashboard_medico',compact('consultas'));
            }
        }

        return redirect('/');

    }

    /**view notificacoes medico */
public function notificacao(){

    if(Auth::check()){
        if(Auth::user()->Nivel === 1){
        
            return view('medicos.notificacacoes');

        }


        return redirect()->back();
    }
    
    return redirect()->back();
}
/**fim  */

/**Alterar data de atendimento */

public function alterar_data(Request $request){
    if(Auth::check()){

        if(Auth::user()->Nivel === 1){

            $this->validate($request,[
                'data'=>'required',
                'id_consulta'=>'required'
            ]);

            $consulta = Consulta::where('id_consulta',$request->id_consulta)->first();
            $mes_db = Carbon::parse($consulta->data_realizacao)->format('m');
            $datetime  = new DateTime('now');
            $mes = Carbon::parse( $datetime)->format('m');

          
       

            if( $mes > $mes_db ){

                    return redirect()->back()->with('warning','Só pode alterar a data de atendimento antes de um mês');

            }elseif($consulta->data_realizacao === null){

                return redirect()->back()->with("warning","Não pode alterar a data porque ainda não foi definida!");

            }

           
            $consulta->data_realizacao = $request->data;
            $consulta->save();


            if($consulta){

                // buscar usuario utente
                $utente = Utente::where('id_utente',$consulta->id_utente)->first();
                User::where('id_usuario',$utente->id_usuario)->first()->notify(new DataAlterada($consulta->data_realizacao,$consulta->tipo_exame));
                
                return redirect()->back()->with("success","Data alterada com sucesso.");
                    

            }




        }
    }
}
   
 
    
}
