<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MedicosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtenteController;
use App\Models\Consulta;
use App\Models\Endereco;
use App\Models\Especialidade;
use App\Models\Exame;
use App\Models\Medico;
use App\Models\User;
use App\Models\Utente;
use Facade\FlareClient\View;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**--------------------------------Pagina inicial----------------------------*/
Route::get('/',[HomeController::class,'index']);
// Pagina Contacto
Route::get("/fale.conosco", [HomeController::class,"fala_conosco"]);
Route::post("/enviar.mensagem", [HomeController::class,"contacto"]);

/**--------------------------------------------------------------------------*/

/**----------------------Operações de Utente-------------------------------- */
Route::get('/cadastrar.utente',[UtenteController::class,'create']);
Route::post('/utente.novo',[UtenteController::class,'store']);

/**Notificações */
Route::get('/notificacao_utente',[UtenteController::class,'notificacao_utente']);
Route::get('/notificacaes.lidas',[UtenteController::class,'notificacoes_lidas']);
Route::get('/notificacao.lida/{id}',[UtenteController::class,'notificacao_lida']);
Route::get('/remover/{id}',[UtenteController::class,'deletar_notificacao']);
/**Fim das notificações */
//inserir doencas hereditarias e alergias no rcu de utente
Route::post('/doenca',[UtenteController::class,'doenca_hereditaria']);
Route::post('/alergia',[UtenteController::class,'alergias']);
// fim 
/**------------------------------------------------------------------------ */
/**----------------Autenticação de Usuarios----------- --------------------*/
Route::get('/logar',[UserController::class,'index']);
Route::post('/entrar',[UserController::class,'logar']);
Route::get('/sair',[UserController::class,'Sair']);
Route::get('/perfil',[UserController::class,'perfil']);
/**------------------------------------------------------------------------ */

/**--------------Actualizar dados do perfil de usuario-------------------------*/
/**Alterar dados pessoais */
Route::put('/alterar.perfil.medico',[UserController::class,'alterar_dados_medico']);
Route::put('/alterar.perfil.utente',[UserController::class,'alterar_dados_utente']);
Route::put('/alterar.perfil.admin',[UserController::class,'alterar_dados_admin']);
/**---------------------------------------------------------------------------*/
/**Carregar imagem de usuario */
Route::put('/alterar.imagem',[UserController::class,'carregar_imagem']);
/**---------------------------------------------------------------------------*/
/**alterar senha de usuario */
Route::put('/alterar.senha',[UserController::class,'alterar_senha']);
/**---------------------------------------------------------------------------*/
/**apagar conta de usuario */
Route::post('/apagar.utente',[UserController::class,'apagar_conta']);
/**---------------------------------------------------------------------------*/
Route::post('/redifinir',[UserController::class,'redefinir_senha']);
Route::get('/recuperar.senha',[UserController::class,'recuperar_senha']);
/**--------------------------------------------------- */

/**------------------------Area administrativa------------------------*/
/**------------------------Dashboard Admin---------------------------*/
Route::get('/admin.dashboard',[AdminController::class,'dashboard'])->name('admin');
Route::get('/admin.dashboard',[AdminController::class,'index']);
Route::post('/enviar/email',[AdminController::class,'enviar_email']);
Route::get('/notificacao',[AdminController::class,'notificacao_admin']);

/**-------------------------------Acoes na entidade medico----------------------------------------------------------*/
Route::get('/medico/deletar/{id}',[AdminController::class,'deletar_medico']);
Route::post('/cadastrar.medico',[AdminController::class,'adicionar_medico']);
Route::get('/medico.listar',[AdminController::class,'listar_medicos'])->name('medico.listar');
Route::put('/medico.editar',[AdminController::class,'editar_medico']);
Route::get('/dashboard.medico',[MedicoController::class,'gerir_utentes']);
Route::get('/notificacao_admin',[AdminController::class,'notificacao_admin']);
//Medico 
 Route::get('/notificacao_medico',[MedicoController::class,'notificacao']);
 Route::post(' /alterar.atendimento.consulta',[MedicoController::class,'alterar_data']);
/**-------------------------------------------------------------------------------------------- */
/**------------------------------------------------------------------------------------------- */
/**----------------------------------------Acoes na entidade especialidade--------------------------------------------------- */
Route::get('/especialidade/deletar/{id}',[AdminController::class,'deletar_especialidade']);
Route::post('cadastrar.especialidade',[AdminController::class,'adicionar_especialidade']);
Route::get('/especialidade.listar',[AdminController::class,'listar_especialidade'])->name('especialidade.listar');
Route::get('/ver/{id}',[AdminController::class,'mostrar_exame']);
Route::put('/editar.especialidade',[AdminController::class,'editar_especialidade']);
/**--------------------------------------------------------------------------------------------- */
Route::get('/exame/deletar/{id}',[AdminController::class,'deletar_exame']);
Route::post('cadastrar.exame',[AdminController::class,'adicionar_exame']);
Route::get('/exame.listar',[AdminController::class,'listar_exame'])->name('exames.listar');
Route::put('/exame.editar',[AdminController::class,'editar_exame']);
Route::get('/utente.listar',[AdminController::class,'listar_utentes'])->name('utente.listar');

/**---------------------------------------------------------------------------------------------- */
/**------------------------Listar Medicos------------------------------------------------------ */
Route::get('/mostrar/{id}',[UtenteController::class,'registro_clinico']);
Route::get('/utente/historico/{id}',[UtenteController::class,'historico']);
Route::get('/utente/alergias/{id}',[UtenteController::class,'alergia']);
Route::post('/historico/add',[UtenteController::class,'historico_add']);

/**----------------------------------------------------------------------------------------------*/
/**-------------------------------------Consultas-------------------------------------------------- */
Route::get('/consulta.listar',[ConsultaController::class,'listar_consulta']);

Route::get('/selecionar',[ConsultaController::class,'formSelecionarEspecialidade']);
Route::post('/selecionado',[ConsultaController::class,'select_especialidade']);

Route::post('/finalizar',[ConsultaController::class,'finalizar']);
Route::post('/atendimento.consulta',[ConsultaController::class,'dataHoraConsulta']);
Route::post('/consulta.terminada',[ConsultaController::class,'consulta_terminada']);
Route::get('/{idconsulta}/remover',[ConsultaController::class,'consulta_remover']);
/**---------------------------------------------------------------------------------------------- */
 


/**Imprimir relatorios */
Route::get('/relatorio.consulta',[AdminController::class,'gerar_relatorio_consulta']);
Route::get('/relatorio.utente',[AdminController::class,'gerar_relatorio_utente']);
Route::get('/relatorio.medico',[AdminController::class,'gerar_relatorio_medico']);
Route::get('/relatorio.especialidade',[AdminController::class,'gerar_relatorio_especialidade']);
Route::get('/relatorio.exame',[AdminController::class,'gerar_relatorio_exame']);

// adicionar cartao dem vacina

Route::post('/adicionar/cartao',[UtenteController::class,'adicionar_cartao_vacina']);
Route::get('/cartao/{id}',[UtenteController::class,'Ver_cartao_vacina']);
Route::get('/download/{id}',[UtenteController::class,'dowload_anexo']);
  Route::get('hash',function(){
      return Hash::make('mar12345');
  });



