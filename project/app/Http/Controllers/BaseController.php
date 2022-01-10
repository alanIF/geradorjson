<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Base;
use Illuminate\Support\Facades\Auth;
use Redirect;

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
       
    

       
        return Redirect::to('/base/new')->with('status', 'base criada com sucesso');;
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
        $base->delete();

        return Redirect::to('/base')->with('status', 'base excluída com sucesso');;
    }
}

