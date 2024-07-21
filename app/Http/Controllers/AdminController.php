<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoRequest;
use App\Mail\emailUtente;
use App\Models\Consulta;
use App\Models\Contacto;
use App\Models\Endereco;
use App\Models\Especialidade;
use App\Models\Exame;
use App\Models\User;
use App\Models\Medico;
use App\Models\Utente;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DateTime;
use PDF;

class AdminController extends Controller{

     /**Retornar dashboard do administrador  */ 
     public function dashboard(){
        if(Auth::check()){

            if(Auth::user()->Nivel === 2){

               
                return view('admin.dashboard');
            }
            return redirect('/');

        }
            return redirect('/');
    }
    /**Retornar pagina inicial da dashboard do administrador*/
    public function index(){
        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
             $administradores = User::where('Nivel',2)->get();
          
                $medicos = Medico::count();
                $exames = Exame::count();
                $consultas = Consulta::count();
                $utentes = Utente::count();
         
                /**Informacoes para preencher o grafico */
                $data= Consulta::select('id_consulta','created_at')->get()->groupBy(function($data){
                     return   Carbon::parse($data->created_at)->format('M');
                });
                $months = [];
                $monthCount = [];
               foreach($data as $month => $values){
                        $months[] = $month;
                        $monthCount[] = count($values);
               }
               /** ----------------fim----------------*/


                return view('admin.index',compact('administradores','medicos','utentes','exames','consultas','data','months','monthCount'));
            }
            return redirect('/');

        }
           
        return redirect('/');
        
        
    }
    /**--------------------------------------------------------------- */

 
    /**--------------------Adicionar medico-------------------------*/
    public function adicionar_medico(Request $request){
     if(Auth::check()){

        if(Auth::user()->Nivel === 2){
        /**VALIDAÇÃO DOS CAMPOS */
          $this->validate($request,[
              'nome'=>'bail|required|between:3,20',
              'nascimento'=>'bail|required',
              'bi'=>'bail|required|min:15|max:15',
              'email'=>'bail|required|email|unique:users',
              'telefone'=>'bail|required',
              'sexo'=>'bail|required',
              'morada'=>'bail|required',
             'localidade'=>'bail|required',
              'especialidade'=>'bail|required'
          ],[
              'email.unique'=> 'Esse email já esta a ser usado.'
          ]);
         
        

         /** fim */
         $dados = $request->all();

        // Verificar se  a data de nascimento é valida
        $data_actual = new DateTime("now");
        $ano = Carbon::parse($request->nascimento)->format("Y");
        $ano_actual=Carbon::parse($data_actual)->format("Y");

            if($ano >  $ano_actual || $ano < 1905){
                return redirect()->back()->with('warning','Data de nascimento inválida.');
            }else{

        /**Se todos os campos forem preenchidos
         *  correctamente adicionar medico ao sistema */
     
        $medico = new Medico();
        $usuario = new User();
        /**Insercao em massa de outros dados do medico */
        $endereco = Endereco::create($dados);
        $contacto = new Contacto();
        $contacto->telefone =$dados['telefone'];
        $contacto->email = $dados['email'];
        $contacto->save();

        /**-------------------------------------------------------- */
        /**Salvar Informações de usuário medico no banco de dados */
        /**----------------------------------------------------- */
        $senha = password_hash('12345678',PASSWORD_DEFAULT);
        $nivel_acesso = 1;
        $usuario->password =  $senha;
        $usuario->Nivel = $nivel_acesso;
        $usuario->nome = $dados['nome'];
        $usuario->email = $dados['email'];
        $usuario->save();
        /**------------------------------------------------------ */
        /**-----------------------Outros dados--------------------------*/
        $medico->nome = $dados['nome'];
        $medico->nascimento = $dados['nascimento'];
        $medico->bi = $dados['bi'];
        $medico->sexo = $dados['sexo'];
        $medico->especialidade = $dados['especialidade'];

        /**Insercao das chaves estrangeiras */
        $medico->id_usuario = $usuario->id_usuario;
        $medico->id_endereco = $endereco->id_endereco;
        $medico->id_contacto = $contacto->id_contacto;
        $medico->save();

        if($contacto && $endereco && $medico){

           return redirect()->back()->with('success','Médico Adicionado com sucesso.');  
        }
        return redirect()->back()->with('error','Erro ao Adicionar Médico '); 
        }

    }
    return redirect('/');

}
   return redirect('/');

}
    /**---------------------------------------------------------------*/


    /** Deletar Medico */
    public function deletar_medico( $id){
        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
              

                $deletar_medico = Medico::where('id_medico',$id)->first();
                $usuario = User::where('id_usuario',$deletar_medico->id_usuario)->first();
                $usuario->delete();
                
                $deletar_medico->delete();
                $deletar_medico->contacto()->delete();
                $deletar_medico->endereco()->delete();
                 

                if($deletar_medico){
                     return redirect()->back()->with('msg','Médico Excluido com sucesso');

                }
            }
            return redirect('/');
        }
    }
    /**Listar todos os medicos cadastrados */
    public function listar_medicos(){
        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
              
                $action = "/cadastrar.medico";
                $especialidades = Especialidade::all();
                $action_buscar = "/medico.listar";
                $action_deletar = "/medico.deletar";
                $medicos = Medico::paginate(10);
                return view('medicos.listar_medicos',['action_deletar'=>$action_deletar,'especialidades'=>$especialidades,'action'=>$action,'medicos'=>$medicos,'action_buscar'=>$action_buscar]);
            }
        }
            return redirect('/');
        
    }
    // Editar medico
    public function editar_medico(Request $request){
        if(Auth::check()){
            if(Auth::user()->Nivel === 2){

                $this->validate($request,[
                    'nome'=>'bail|required',
                    'nascimento'=>'bail|required',
                    'sexo'=>'bail|required',
                    'bi'=>'bail|required|min:15|max:15',
                    'especialidade'=>'bail|required',
                    'morada'=>'bail|required',
                    'localidade'=>'bail|required',
                    'codigo_postal'=>'bail|required',
                    'id'=>'bail|required',

                ]);
                $data_actual = new DateTime("now");
                $ano = Carbon::parse($request->nascimento)->format("Y");
                $ano_actual=Carbon::parse($data_actual)->format("Y");
                if($ano >  $ano_actual || $ano < 1905){
                    return redirect()->back()->with('warning','Data de nascimento inválida.');
                }else{
                    $medico = Medico::findOrFail($request->id);
                    $medico->especialidade = $request->especialidade;
                    $medico->update($request->all());
                    $medico->endereco->update($request->all());
                    $medico->contacto->update($request->all());
                    if($medico){
                       
                    return redirect()->back()->with('success','Medico editado com sucesso');
                    }
                     

                    return redirect()->back()->with('error','Erro ao editar médico');
                }
            } 
             return redirect()->back();
        }
      
    }

/**Adicionar especialidade */
    public function adicionar_especialidade(Request $request){
        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
           
                $this->validate($request,[
                    'especialidade'=>'bail|required|unique:especialidades',
                   
                ],['especialidade.unique'=>'Especialidade já existe.']);
                              $dado = $request->all();
                $especialidade = new Especialidade();

                if(isset($dado['imagem'])){
                    if($request->has('imagem') && $request->hasFile('imagem')){

                            $imagem = $request->file('imagem');
                            $extensao = $imagem->getClientOriginalExtension();
                            $nome_imagem = md5($imagem->getClientOriginalName()).'.'.$extensao ;
                            $request->file('imagem')->storeAs('public/especialidade/',$nome_imagem);
                            $dado['imagem'] = $nome_imagem;
                        

                    }
                  
                    $especialidade->imagem = $dado['imagem'];


                    
                  }else{

                    $especialidade->imagem = "Nenhuma";
                  }

                  $especialidade->especialidade = $dado['especialidade'];

                 $especialidade->save();

                 if($especialidade){
              
                      return redirect()->back()->with('success','Especialidade adicionada com sucesso');
                  }
                  return redirect()->back()->with('error','Erro ao  adicionadar especialidade');

            }

            return redirect('/');
        }

    }
    /**Editar Especilidade */


public function editar_especialidade(Request $request){
    if(Auth::check()){

        if(Auth::user()->Nivel === 2){
    $especialidade = Especialidade::find($request->id_especialidade);
    $dados = ['especialidade'=>$request->nome,'imagem'=>$request->imagem];
 
    if($request->has('imagem') && $request->hasFile('imagem')){

        $imagem = $request->file('imagem');
        $extensao = $imagem->getClientOriginalExtension();
        $nome_imagem = md5($imagem->getClientOriginalName()).'.'.$extensao ;
        $request->file('imagem')->storeAs('public/especialidade/',$nome_imagem);
        $dados['imagem'] = $nome_imagem;
    

     }
   
     if($dados['imagem'] === null){
        $especialidade->imagem = 'Nenhuma';
     }

      
     $especialidade->especialidade = $dados['especialidade'];
     $especialidade->imagem = $dados['imagem'];
     $especialidade->save();
        
    if($especialidade){

        
        return redirect()->back()->with('success','Especialidade Editada com sucesso');
    }

    return redirect()->back()->with('error','Erro ao  editadar especialidade.');


        }
    } 
}
/**---------------------------------------------------- */
   public function listar_especialidade(){
    if(Auth::check()){
        if(Auth::user()->Nivel === 2){
      $action = "/cadastrar.especialidade";
      $action_buscar = "/especialidade.listar";
      $action_deletar = "/especialidade.deletar";

        $especialidades = Especialidade::paginate(5);

      return view('especialidades.listar_especialidade',['action'=>$action,'especialidades'=>$especialidades,'action_deletar'=>$action_deletar,'action_buscar'=>$action_buscar]);
   }

   return redirect('/');
}
}
    // deltar especialidade
    public function deletar_especialidade($id){

        if(Auth::check()){

            if(Auth::user()->Nivel === 2){
                $deletar_especialidade = Especialidade::destroy($id);
               
                if($deletar_especialidade){
                return redirect()->back();
             } 
         }
            return redirect()->back();
        }
    }
    /**-------------------------------------------------------------------------------------- */


 /** */
    /**deletar exame */
     public function deletar_exame($id){
        if(Auth::check()){

            if(Auth::user()->Nivel === 2){

                $deletar_exame = Exame::destroy($id);

                if($deletar_exame){
                    return redirect()->back();
                }
           }
         return  redirect('/');
        }
     }

     /** ---------------------------------------------------------------*/
    
    /**Adicionar exame */
    public function adicionar_exame(Request $request){
        if(Auth::check()){

            if(Auth::user()->Nivel === 2){
        /**Validação dos campos */
       $this->validate($request,[
            'nome'=>'bail|required|between:3,60',
            'id_especialidade'=>'bail|required|numeric'
       ],[
           'nome.required'=>'Campo exame é obrigatório',
           'id_especialidade.required'=>'Campo especialidade é obrigatório',
       ]
        );
        
         
        /**Se todos os campos forem preenchidos correctamente */
        $dado = $request->all();
        $exame = Exame::create($dado);

        if($exame){
            return redirect()->back()->with('success','Exame adicionado com sucesso.');
        } 

        return redirect()->back()->with('error','Erro ao  adicionar exame.');

      }
      return redirect('/');
     }
    }
    /**------------------------------Listar Exames--------------------------------------------*/
    public function listar_exame(){

        if(Auth::check()){

            if(Auth::user()->Nivel === 2){

        $especialidades = Especialidade::all();
        $action = "/cadastrar.exame";
        $action_buscar = "/exame.listar";
        $action_deletar = '/exame.deletar';

         $exames = DB::table('exames')
        ->join('especialidades','exames.id_especialidade','=','especialidades.id_especialidade')
        ->paginate(5);
      
        return view('exames.listar_exame',['action_buscar'=>$action_buscar,'action'=>$action,'exames'=>$exames,'especialidades'=>$especialidades,'action_deletar'=>$action_deletar]);
    }

    return redirect('/');
 }
    }
    /**editar Exame */
    public function editar_exame(Request $request){
        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
          $this->validate($request,['nome'=>'bail|required','id_especialidade'=>'bail|required']);
            $dados = $request->all();
          $exame = Exame::findorFail($request->id_exame);
                $exame->update($dados);

                if($exame){

                    return redirect()->back()->with('success','Exame editado com sucesso');
                }
                return redirect()->back()->with('error','Erro ao editar Exame');
            }
        }
      
    }


    /** */
 /**Listar todos os utentes cadastrados no sistema*/
   public function listar_utentes(){
        
    if(Auth::check()){
        if(Auth::user()->Nivel === 2){
                $utentes = Utente::paginate(10); 
            return view('utentes.listar_utentes',['utentes'=>$utentes]);

        }
        return redirect('/');
    }
        return redirect('/');
}
   


        // Enviar email para utente

        public function enviar_email(Request $request){
            // Verificar se o campo  de contudo esta preenchido
         if($request->textconteudo === null){
            return redirect()->back()->with('warning','Não pode enviar um email vazio.Preencha o campo,porfavor ');
         }
         //Buscar Email na tabela contacto
         $email = Contacto::where('email',$request->email)->first();
         if(!$email){
            return redirect()->back()->with('warning','E-mail não encontrado.');

         }
        //  Enviar o email para o utente
            try
            {
                Mail::to($email)->send(new emailUtente($request->textconteudo));
                return redirect()->back()->with('success','Email enviado com sucesso');

            }catch(\Exception $ex)
            {
                return redirect()->back()->with('error','Erro ao enviar e-mail! Verifica sua conexao com a internet, e tente novamente.');

            }



        }


        /**retornar a view de  notificacoes do admin */
    public function notificacao_admin(){

    if(Auth::check()){
        if(Auth::user()->Nivel === 2){
        
            return view('admin.notificacao');

        }
        return redirect()->back();
    }
    
    return redirect()->back();
}

/**gerar relatorio de consultas  */
public function gerar_relatorio_consulta(){

    $consulta = Consulta::all();
    $pdf = PDF::loadView('relatorio.relatorio_consulta',['dados'=>$consulta,'titulo'=>'Relatório de Consultas']);
    return $pdf->stream('kerubim_2022_consultas.pdf');

}
/**gerar relatorio de utentes  */
public function gerar_relatorio_utente(){

    $utente = Utente::all();
    $pdf = PDF::loadView('relatorio.relatorio_utente',['dados'=>$utente,'titulo'=>'Relatório de Utentes']);
    return $pdf->stream('kerubim_2022_utentes.pdf');

}
/**gerar relatorio de medicos  */
public function gerar_relatorio_medico(){

    $medico = Medico::all();
    PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
    $pdf = PDF::loadView('relatorio.relatorio_medico',['dados'=>$medico,'titulo'=>'Relatório de Medicos']);
    return $pdf->stream('kerubim_2022_medicos.pdf');

}
/**gerar relatorio de especialidades  */
public function gerar_relatorio_especialidade(){

    $especialidade = Especialidade::all();
    $pdf = PDF::loadView('relatorio.relatorio_especialidade',['dados'=>$especialidade,'titulo'=>'Relatório de Especialidades']);
    return $pdf->stream('kerubim_2022_especialidades.pdf');

}
/**gerar relatorio de exames  */
public function gerar_relatorio_exame(){

    $exame = Exame::all();
    $pdf = PDF::loadView('relatorio.relatorio_exame',['exames'=>$exame,'titulo'=>'Relatório de Exames']);
    return $pdf->stream('kerubim_2022_exame.pdf');

}

/**fim */


// Mostrar exames pertencentes a uma determinada especialidade
public function mostrar_exame($id)
{
    $exames = Exame::where("id_especialidade",$id)->get();
    return view('exames.mostrar',compact('exames'));

}
 }


    