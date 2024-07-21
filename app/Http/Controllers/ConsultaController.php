<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Especialidade;
use App\Models\Exame;
use App\Models\HistoricoClinico;
use App\Models\Medico;
use App\Models\Utente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroClinico;
use App\Models\User;
use App\Notifications\AdminNotificacao;
use App\Notifications\CancelarConsulta;
use Carbon\Carbon;
use App\Notifications\ConsultasUsuario;
use App\Notifications\DataRealizacao;
use App\Notifications\MedicoNotificacao;
use DateTime;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    
    public function formSelecionarEspecialidade()
    {
    if(Auth::check()){
        if(Auth::user()->Nivel === 0){
            
            $especialidades = Especialidade::all();
            $action = '/selecionado';
             
            return view('consulta.selecionar_especialidade',compact('especialidades','action' ));
        }
    }
   
        return redirect('/');
    }

// Selecionar especialidade
    public function select_especialidade(Request $request){
        if(Auth::check()){
            if(Auth::user()->Nivel === 0){
                       
               
                 $especialidade = Especialidade::find($request->especialidade);
                 $medicos = Medico::where('especialidade',$especialidade->especialidade)->get();
                //  $exames = DB::select('SELECT Ex.nome FROM exames Ex inner join especialidades E on Ex.id_especialidade = E.id_especialidade WHERE E.id_especialidade =?',[$especialidade->especialidade]);
                 $exames = Exame::where('id_especialidade',$request->especialidade)->get();
                 $action = "/finalizar";
                 $utente = Utente::where('id_usuario',Auth::user()->id_usuario)->first();
                 return view('consulta.marca_consulta',compact('action','medicos','exames','utente'));
            }
        }
       
            return redirect('/');
    }

  
     

/**Marcar as consultas */
    public function finalizar(Request $request){

        /**Validacao dos campos */
        $this->validate($request,[
            'tipo_exame'=>'required',
            'id_medico'=>'required',
            
        ]);
    
        $dados = $request->all();
            // Verificar se a consulta ja existe e se ja foi realizada
            $consultaVerificar = Consulta::where('tipo_exame',$dados['tipo_exame'])->first();
            
            if($consultaVerificar)
            {
            if($consultaVerificar->status === 0)
            {

                return redirect()->back()->with('warning','Já marcou essa consulta e ainda não foi realizada! Não pode marcar novamente em quanto não for realizada.');
            }

            }

            // fim da verificacao
        
        $consulta =  new Consulta();
        
        if(isset($dados['anexo'])){
            if($request->has('anexo') || $request->hasFile('anexo')){
                $file = $request->file('anexo');
                $extension = $file->getClientOriginalExtension();
                if($extension != 'pdf')
                {
                    return redirect()->back()->with('warning','Só pode carregar arquivos pdf.');

                }
                $fileName = md5($file->getClientOriginalName()).'.'.$extension;

                $request->file('anexo')->storeAs('public/anexosConsultas/',$fileName);
                $dados['anexo'] = $fileName;
            }
            $consulta->anexos = $dados['anexo'];

        }else{

            $consulta->anexos = "Nenhum";
        }
        $data_marcacao = new DateTime('now');
        $data_marcacao->format('d-m-Y H:i:m');
        $consulta->tipo_exame = $dados['tipo_exame'];
        $consulta->data_marcacao = $data_marcacao->format('Y-m-d H:i:s') ;
        $consulta->data_realizacao = null;
        $consulta->id_medico = $dados['id_medico'];
        $consulta->id_utente = $request->id_utente;

        $consulta->save();
            
        $historicoClinico = HistoricoClinico::where('id_utente',$dados['id_utente'])->first();

        if($historicoClinico->exame_efetuado === null){

            $historicoClinico->exame_efetuado = $dados['tipo_exame'];
            $historicoClinico->save();

        }else{

            $historicoClinico = new  HistoricoClinico();
            $historicoClinico->exame_efetuado = $dados['tipo_exame'];
            $historicoClinico->id_utente = $dados['id_utente'];
            $historicoClinico->medico = $dados['id_medico'];
            $historicoClinico->save();
        }

        /**Buscar utente que marcou a consulta */
        $utente = Utente::where("id_usuario",Auth::user()->id_usuario)->get();
    
        $nome_utente = "";
        $codigo = "";
        foreach($utente as $utente){

            $nome_utente  = $utente->nome;
            $codigo = $utente->id_utente;
        }
                
            
        if($consulta && $historicoClinico){
        
            User::where("id_usuario",Auth::user()->id_usuario)->first()->notify(new ConsultasUsuario());
            User::where("Nivel",2)->first()->notify(new AdminNotificacao($nome_utente,$codigo));
            return redirect('/')->with('success','Consulta marcada com sucesso');
        }
    
        return redirect()->back()->with('error','Erro ao marcar consulta');
        
           
    }


    /**Listar as consultas */
    public function listar_consulta(){

        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
                        
            //    $consultas = Consulta::orderBy('id_consulta','DESC')->get();
               $consultas = Consulta::orderBy('id_consulta','DESC')->paginate(5);
                return view('consulta.listar_consulta',compact('consultas'));

            }
        }
        return redirect('/');
     }
    
     //  Definir data e hora da consulta
     public function dataHoraConsulta(Request $request){
         if(Auth::check()){
            if(Auth::user()->Nivel === 2){
                $this->validate($request,[
                    
                    "data"=>"required",
                    'id_consulta'
                    
                ]);
            // Verificar se  a data é valida
            $data_actual = new DateTime("now");
            $ano=Carbon::parse($request->data)->format("Y");
            $ano_actual=Carbon::parse($data_actual)->format("Y");

                if($ano >  $ano_actual){
                    return redirect()->back()->with('warning','A data definida não é válida.');
                }else{
                /** Buscar consulta selecionada por id */
                $consulta = Consulta::where('id_consulta',$request->id_consulta)->first();
                /**Buscar o utente que marcou essa consulta e notifica - lo da hora e data da consulta */
                $utente = Utente::where('id_utente',$consulta->id_utente)->first();
                $usuario = User::where('id_usuario',$utente->id_usuario)->first();
                //Buscar o medico pertencete a consulta para notifica-lo da data e hora de atendimento
                $medico = Medico::where('id_medico',$consulta->id_medico)->first();
                $usuario_medico = User::where('id_usuario',$medico->id_usuario)->first();
           

                if($request->has('anexo') && $request->hasFile('anexo')){
                    $aquivo = $request->file('anexo');
                    $extensao = $aquivo->getClientOriginalExtension();
                    $nome_aquivo = md5($aquivo->getClientOriginalName()).'.'.$extensao ;
                    $request->file('anexo')->storeAs('public/anexoConsulta',$nome_aquivo);

                    $consulta->anexos = $nome_aquivo;
                        
                }
                
                $consulta->data_realizacao = $request->data;
                $consulta->save();
                  
             
                if($consulta){
                    
                    User::where("id_usuario",$usuario->id_usuario)->first()->notify(new DataRealizacao($consulta->data_marcacao,$consulta->data_realizacao));
                    User::where("id_usuario",$usuario_medico->id_usuario)->first()->notify(new MedicoNotificacao($utente->nome,$consulta->data_realizacao,$consulta->tipo_exame));

                    return redirect()->back()->with('success','Data e Hora de Atendimento definidos.');

                }
                
                return redirect()->back()->with('error','Erro ao definir Data e Hora de Atendimento.');
            } 
            }
            return redirect()->back();
         }

     }
    
       /**Marcar consulta como terminada / finalizada */
     public function consulta_terminada(Request $request){

        if(Auth::check()){
            if(Auth::user()->Nivel === 1){

                $consulta = Consulta::find($request->id_consulta)->first();
                
                if($consulta->dataHoraConsulta === null){

                    return redirect()->back()->with('warning','Não pode marcar a consulta como terminada, porque ainda não foi realizada.');

                }
                $consulta->status = $request->id_consulta;
                $consulta->save();
                if($consulta){

                    return redirect()->back()->with('success','Consulta marcada como terminada');

                   
                }
                return redirect('dashboard.medico')->with('error',' Erro ao  marcar a consulta como terminada.');

            }
        }
     }

     public function consulta_remover($idconsulta)
     {
         $consulta = Consulta::find($idconsulta);
         
         if($consulta)
         {
            $utente = Utente::find($consulta->id_utente);
            User::find($utente->id_usuario)->notify(new CancelarConsulta($consulta->tipo_exame,$consulta->data_marcacao));
             
            $consulta->delete($idconsulta); 
            return redirect()->back()->with('success','Consulta removida com sucesso.');
        }
      
         return redirect()->back()->with('error','Erro ao  remover consulta.');

     }
}
