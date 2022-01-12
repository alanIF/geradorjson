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
            return response()->json($date);

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
                if($i!=0){
                    array_push($dados,$registro);

                }
                $i++;
            }
            fclose($f);
            }
            return $dados;

    }}

