<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Contacto;
use App\Models\Endereco;
use App\Models\HistoricoClinico;
use App\Models\RegistroClinico;
use App\Models\Medico;
use App\Models\User;
use App\Models\Utente;
use App\Notifications\ConsultasUsuario;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Monolog\Registry;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;


class UtenteController extends Controller
{
    
    
    /*-------retornar formulario de cadastro de utente--------*/
    public function create()
    {
        $action = 'utente.novo';
        return view('users.register',['action'=>$action]);
    }
    /**------------------------------------------------------ */

    /**--------------------Cadastrar utentes----------------- */
    public function store(Request $request){
        /**VALIDAÇÃO DOS CAMPOS */
        $dados = $request->all();
        $this->validate($request,[
            'nome'=>'bail|required|between:3,20',
            'nascimento'=>'bail|required',
            'bi'=>'bail|required|min:15|max:15',
            'email'=>'bail|required|email|unique:users',
            'telefone'=>'bail|required|min:9|max:13',
            'password'=>'bail|required|min:8',
            'sexo'=>'bail|required',
            'seguro'=>'bail|required',
            'seguro_numero'=>'bail|required',
            'morada'=>'bail|required',
            'localidade'=>'bail|required',
            'comfir_senha'=>'bail|required|min:8'
        ],[
            'email.unique'=>'E-mail já esta sendo usado.',
            'password.required'=>'Campo obrigatório.',
            'comfir_senha.required'=>'Campo obrigatório.',
            'telefone.required'=>'Campo obrigatório.',
        ]);
            
        /**SE TODOS OS CAMPOS FOREM PREENCHIDOS CORRECTAMENTE FAZER
         *  A INSERÇÃO NO BANCO DE DADOS */
        
        $dados = $request->all();

         /**Verificar se o campo senha e igual a confirmar senha*/
              

    if($dados['password'] === $dados['comfir_senha']){

        $data_actual = new DateTime("now");
        $ano=Carbon::parse($request->nascimento)->format("Y");
        $ano_actual=Carbon::parse($data_actual)->format("Y");

            if($ano >  $ano_actual || $ano < 1905){
                return redirect()->back()->with('warning','Data de nascimento inválida.');
            }
          /** */
        $password_hash = password_hash($request->password,PASSWORD_DEFAULT);
        $dados['password'] = $password_hash;    
        /** Entidade utente instanciada*/
         $utentes = new Utente();
         /**Insercao de dados na tabela enderecos e contactos */
         DB::beginTransaction();
        $endereco = Endereco::create($dados);
        $contacto = Contacto::create($dados); 
        $usuario = User::create($dados);        
        /** Insercao dos dados do pessoais do utente */
        
        $utentes->nome = $dados['nome'];
        $utentes->nascimento = $dados['nascimento'];
        $utentes->seguro = $dados['seguro'];
        $utentes->sexo = $dados['sexo'];
        $utentes->seguro_numero = $dados['seguro_numero'];
        $utentes->bi = $dados['bi'];

        /**insercao das chaves estrangeiras */
        $utentes->id_endereco = $endereco->id_endereco;
        $utentes->id_contacto = $contacto->id_contacto;
        $utentes->id_usuario = $usuario->id_usuario;
        /**------------------------------------------ */

        $utentes->save();

        $rcu_utente = new  RegistroClinico();
        $rcu_utente->id_utente = $utentes->id_utente;
        $rcu_utente->save();

        $historicoClinico = new HistoricoClinico();
        $historicoClinico->id_utente = $utentes->id_utente;
        $historicoClinico->save();

        DB::commit();
        if($utentes){
       
            
            return redirect('/logar')->with('success','Parabéns seu cadastro foi realizado com sucesso.');
        }


    }

    return redirect()->back()->with('warning','As senhas digitadas são diferentes.');

        
 
    }
    /**Apresentar registro clinico de utente */
    public function registro_clinico($id){
        if(Auth::check()){

            if(Auth::user()->Nivel === 0){
                 
                $utente = Utente::where('id_usuario',$id)->first();
                $registro_clinico  = RegistroClinico::where('id_utente',$utente->id_utente)->first();
                $id = $registro_clinico->id_utente;
                $consulta = Consulta::where('id_utente',$id)->get();
                $historico_clinico = HistoricoClinico::where('id_utente',$id)->get();
    
                return view('utentes.registro_clinico',['utente'=>$utente,'registro_clinico'=>$registro_clinico,'id'=>$id,'historico_clinicos'=>$historico_clinico,'consulta'=>$consulta]);
       
               
                   
                
            }elseif( Auth::user()->Nivel ===  2){

                $utente = Utente::where('id_utente',$id)->first();
                $registro_clinico  = RegistroClinico::where('id_utente',$utente->id_utente)->first();
                
                $id = $registro_clinico->id_utente;
                $consulta = Consulta::where('id_utente',$id)->get();
                $historico_clinicos = HistoricoClinico::where('id_utente',$id)->get();

                 return view('utentes.registro_clinico',compact('utente','registro_clinico','id','consulta','historico_clinicos'));

            }elseif( Auth::user()->Nivel ===  1){
                $utente = Utente::where('id_utente',$id)->first();
                $registro_clinico  = RegistroClinico::where('id_utente',$utente->id_utente)->first();
                $id = $registro_clinico->id_utente;
                $historico_clinicos = HistoricoClinico::where('id_utente',$id)->get();

                //**Buscar medico da consulta */
                $medico = Medico::where("id_usuario",Auth::user()->id_usuario)->first();
               
                $consulta = DB::select('select * from consultas where id_utente = ? and id_medico = ? ',[$id,$medico->id_medico]);
                $historico_clinicos = HistoricoClinico::where('id_utente',$id)->get();

               
              return view('utentes.registro_clinico',compact('utente','registro_clinico','id','consulta','historico_clinicos','medico'));
            }

            return redirect('/');
        }
    }
    /**------------------------------------------------------------------------ */
   
  
   
/**adicionar Doencas Hereditarias */

 public function doenca_hereditaria(Request $request){
   
    $rcu = RegistroClinico::where('id_utente',$request->id_utente)->first();
    
    if(!isset($rcu)){


        $RcuUtente =  new RegistroClinico();

        if($request->has('boletim') && $request->hasFile('boletim')){
            $boletim = $request->file('boletim');
            $extensao = $boletim->getClientOriginalExtension();
            $nome_boletim = md5($boletim->getClientOriginalName()).'.'.$extensao ;
            // $request->file('boletim')->storeAs('public/cartaoVacina/',$nome_boletim);
            $boletim->move(public_path('cartaoVacina'),$nome_boletim );
            $RcuUtente->boletim =  $nome_boletim;
        }

       
        if( $request->boletim === null){
            $request->boletim  = 'Nenhum adicionado';
        }

        $RcuUtente->historico_saude = $request->historico_saude;
        $RcuUtente->id_utente = $request->id_utente;
        $RcuUtente->save();
        if($RcuUtente){
            
            return  response()->json(['success'=>'Sucesso ao adicionar']);
        }
        return  response()->json(['error'=>'Erro ao adicionar']);
      
    }else{
           
            $rcu = RegistroClinico::where('id_utente',$request->id_utente)->first();
            $rcu->historico_saude = $request->historico_saude;
            $rcu->boletim_vacina = "Nenhum adicionado";
            $rcu->save();
            return  response()->json(['success'=>'Sucesso ao editar']);
           
           } 
           return  response()->json(['error'=>'Erro ao editar']);
          
 
 }
/**Adicionar Alergias  e Grupo sanguinio */
public function alergias(Request $request){
    $rcu = RegistroClinico::where('id_utente',$request->id_utente)->first();
   
    if(!isset($rcu)){
        $RcuUtente =  new RegistroClinico();
        if($request->grupo_sanguinio === null){
            $request->grupo_sanguinio = ".";
        }
        $RcuUtente->alergias= $request->alergias;
        $RcuUtente->id_utente = $request->id_utente;
        $RcuUtente->grupo_sanguinio = $request->grupo_sanguinio;
        $RcuUtente->save();
        if($RcuUtente){
            return  response()->json(['success'=>'Sucesso ao Adicionar']);
          
        }
        return  response()->json(['error'=>'Erro ao Adicionar']);
      
    }else{
           
            $rcu = RegistroClinico::where('id_utente',$request->id_utente)->first();
            $rcu->alergias = $request->alergias;
            $rcu->grupo_sanguinio = $request->grupo_sanguinio;
            $rcu->save();
            if($rcu){
                return  response()->json(['success'=>'Sucesso ao Editar']);
            }
            return  response()->json(['error'=>'Erro ao Editar']);
           
    } 
        
}

/**Retorna todo Historico familiar  de saude */
    public function historico($id){
        $historico = RegistroClinico::where('id_utente',$id)->first();
        return response()->json($historico);
    }



/**Fim  */

/**retorna todas Alergias */
public function alergia($id){
  
    $alergias = RegistroClinico::where('id_utente',$id)->first();

    return response()->json($alergias);
}



/**Fim  */


/**view notificacoes utente */
public function notificacao_utente(){

    if(Auth::check()){
        if(Auth::user()->Nivel === 0){
        
            return view('utentes.notificacoes');

        }


        return redirect()->back();
    }
    
    return redirect()->back();
}
/**fim  */





/**marcar todas notificacoes como lidas */
public function notificacoes_lidas(){
 Auth::user()->unreadNotifications->markAsRead();   
 return redirect()->back();
}


/**fim */
/**marcar uma notificacao como lida */
public function notificacao_lida($id){

   
   $notification = \Auth::user()->notifications
                            ->where('id',$id)
                            ->first();  
                            
    if($notification){


        $notification->markAsRead();
    }
    
    return redirect()->back();
}


/** */
/**Deletar notificacoes */

 public function deletar_notificacao($id){

      DB::delete('delete from notifications where id = ?',[$id]);

      return redirect()->back();
 }

/**fim */


// Adicionar informações no historico clinico

    public function historico_add(Request $request)
    {
       
        if($request->resultado === null || $request->diagnostico === null || $request->procedimento === null || $request->terapeutica === null){
            
            return redirect()->back()->with('warning','Todos os campos são obrigatórios. Porfavor preencha!');

        }else{

       

        $dados = $request->all();

        $historico = HistoricoClinico::where('id_historico_clinico',$dados['id_historico'])->first();
        $historico->resultado = $dados['resultado'];
        $historico->dignostico = $dados['diagnostico'];
        $historico->procedimento = $dados['procedimento'];
        $historico->terapeutica = $dados['terapeutica'];
        $historico->save();

        if($historico)
        {
            return redirect()->back()->with('success','Informação adicionada');

        }

        return redirect()->back()->with('error','Erro ao adicionar a informação');
    }
 }
// fim

public function adicionar_cartao_vacina(Request $request)
{
   
    // dd($request->cartao);
    if( $request->cartao === null)
    {
        return redirect()->back()->with('warning','Precisa carregar o arquivo antes de clicar em  salvar.');
    }
    if($request->has('cartao') && $request->hasFile('cartao')){
        $cartao = $request->file('cartao');
        $extensao = $cartao->getClientOriginalExtension();
        if($extensao != 'pdf')
        {
            return redirect()->back()->with('warning','Só pode carregar arquivos pdf.');

        }
 
        $nome_arquivo = md5($cartao->getClientOriginalName()).'.'.$extensao ;
        $request->file('cartao')->storeAs('public/cartaoVacina/',$nome_arquivo);
        $request->cartao =  $nome_arquivo;
    }

    $utente = Utente::where('id_usuario',Auth::user()->id_usuario)->first();
    $registro_clinico =RegistroClinico::where('id_utente', $utente->id_utente)->first();;
    // $registro_clinico->boletim = 
   $registro_clinico->boletim_vacina = $request->cartao;
   $registro_clinico->save();

   if($registro_clinico)
   {
    return redirect()->back()->with('success','Cartão de vacina adicionado.');

   }
   return redirect()->back()->with('error','Error ao adicionar cartão de vacina.');



}

public function Ver_cartao_vacina($id)
{
   $registro_clinico = RegistroClinico::find($id)->first();
    return response()->download(public_path().'/storage/cartaoVacina/'.$registro_clinico->boletim_vacina);
     
}
public function dowload_anexo($id)
{
   $consulta= Consulta::find($id)->first();
    return response()->download(public_path().'/storage/anexosConsultas/'.$consulta->anexos);
     
}
}