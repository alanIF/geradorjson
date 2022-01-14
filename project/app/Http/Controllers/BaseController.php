<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Base;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Illuminate\Support\Facades\Storage;
class BaseController extends Controller
{
  
    public function index(){
        $user = Auth::id();

        $sql = 'Select * from base b where b.user_id='.$user.'';
        $bases = \DB::select($sql);
        
        return view('base.index', ['bases' => $bases]);
    }
    // form de cadastrar
    public function new(){
        return view('base.form');
    }
    public function add(Request $request){
        $base = new Base();
        $user = Auth::id();
        
        $base->nome=$request->nome;
       
        $fileName = time().'_'.$request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

 
        $base->descricao=$request->descricao;
        $base->arquivo_csv ='/storage/app/public/' . $filePath;
        $base->user_id= $user;
        $base->save();
       
    

       
        return Redirect::to('/base')->with('status', 'base criada com sucesso');;
    }
    public function update($id ,Request $request){
        $base= Base::findOrFail($id);
        $user = Auth::id();

        $base->nome=$request->nome;
        $base->descricao=$request->descricao;
        $base->user_id= $user;
        $base->save();

        

        return Redirect::to('/base')->with('status', 'base atualizada com sucesso');;
    }
    public function edit($id){
        $base= Base::findOrFail($id);
        return view('base.form', ['base'=> $base]);
    }
    public function delete($id){
        $base= Base::findOrFail($id);
        unlink('../'.$base->arquivo_csv.'');
            
        $base->delete();

        return Redirect::to('/base')->with('status', 'base excluída com sucesso');;
    }

    public function gerar_json($id ,Request $request){
        $base= Base::findOrFail($id);
        $user = Auth::id();
        $delimitador = ';';
        $cerca = '"';

        // Abrir arquivo para leitura
        $f = fopen('../'.$base->arquivo_csv.'', 'r');
        $dados = array();
        $i=0;
        if ($f) { 

            // Ler cabecalho do arquivo
            $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

            // Enquanto nao terminar o arquivo
            while (!feof($f)) { 

                // Ler uma linha do arquivo
                $linha = fgetcsv($f, 0, $delimitador, $cerca);
                if (!$linha) {
                    continue;
                }

                // Montar registro com valores indexados pelo cabecalho
                $registro = array_combine($cabecalho, $linha);

                // Obtendo o nome
                if($i!=0){
                    array_push($dados,$registro);

                }
                $i++;
            }
            fclose($f);
            }
            $date['date']=$dados;
            $dados=  response()->json($date);
            $json_string = json_encode($dados, JSON_PRETTY_PRINT);
            return view('base.json', ['dados' => $json_string]);


    }
    public function gerar_csv($id ,Request $request){
        $base= Base::findOrFail($id);
        $user = Auth::id();
        $delimitador = ';';
        $cerca = '"';

        // Abrir arquivo para leitura
        $f = fopen('../'.$base->arquivo_csv.'', 'r');
        $dados = array();
        $i=0;
        if ($f) { 

            // Ler cabecalho do arquivo
            $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

            // Enquanto nao terminar o arquivo
            while (!feof($f)) { 

                // Ler uma linha do arquivo
                $linha = fgetcsv($f, 0, $delimitador, $cerca);
                if (!$linha) {
                    continue;
                }

                // Montar registro com valores indexados pelo cabecalho
                $registro = array_combine($cabecalho, $linha);

                // Obtendo o nome
                
                    array_push($dados,$registro);

                }
            }
            fclose($f);
          
            return view('base.csv', ['dados' => $dados]);

    }

    public function gerar_sql($id ,Request $request){
        $base= Base::findOrFail($id);
        $user = Auth::id();
        $delimitador = ';';
        $cerca = '"';

        // Abrir arquivo para leitura
        $f = fopen('../'.$base->arquivo_csv.'', 'r');
        $dados = "create database ".$base->nome." ; <br/> use ".$base->nome."; <br/>";
        
        $i=0;
        $create= false;
        if ($f) { 

            // Ler cabecalho do arquivo
            $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);
            $dados =$dados." create table ".$base->nome." (";
            while (!$create){
                for($k=0;$k<count($cabecalho);$k++){
                    if($k==count($cabecalho)-1){
                        $dados=$dados." $cabecalho[$k]"." text );  <br/>";

                    }else{
                        $dados=$dados." $cabecalho[$k]"." text , ";

                    }
                }
                $create=true;

            }

            // Enquanto nao terminar o arquivo
            while (!feof($f)) { 

                // Ler uma linha do arquivo
                $linha = fgetcsv($f, 0, $delimitador, $cerca);
                if (!$linha) {
                    continue;
                }

                // Montar registro com valores indexados pelo cabecalho
                $registro = array_combine($cabecalho, $linha);
                // Obtendo o nome
                if($i!=0){
                    $dados= $dados." insert into ".$base->nome." values (";  

                    for($k=0;$k<count($cabecalho);$k++){
                        if($k==count($cabecalho)-1){
                            $dados=$dados.'"'.$linha[$k].'");  <br/>';
    
                        }else{
                            $dados=$dados.'"'. $linha[$k].'" ,' ;
    
                        }
                    }
                }
                $i++;
            }
                fclose($f);
            }
            return view('base.sql', ['dados' => $dados]);

    }



}

