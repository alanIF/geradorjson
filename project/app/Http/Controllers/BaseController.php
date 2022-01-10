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

        $sql = 'Select * from base b where v.user_id='.$user.'';
        $bases = \DB::select($sql);
        
        return view('base.index', ['bases' => $bases]);
    }
    // form de cadastrar
    public function new(){
        return view('bases.form');
    }
    public function add(Request $request){
        $base = new Base();
        $user = Auth::id();
        $base->nome=$request->nome;

        $base->descricao=$request->descricao;
        $base->arquivo_csv =$request->arquivo_csv;
        $base->arquivo_json=$request->arquivo_json;
        $base->user_id= $user;
        $base->save();
        

       
        return Redirect::to('/base');
    }
    public function update($id ,Request $request){
        $base= Base::findOrFail($id);
        $user = Auth::id();

        $base->nome=$request->nome;
        $base->descricao=$request->descricao;
        $base->arquivo_csv =$request->arquivo_csv;
        $base->arquivo_json=$request->arquivo_json;
        $base->user_id= $user;
        $base->save();

        

        return Redirect::to('/base');
    }
    public function edit($id){
        $base= Base::findOrFail($id);
        return view('base.form', ['base'=> $base]);
    }
    public function delete($id){
        $base= Base::findOrFail($id);
        $base->delete();

        return Redirect::to('/base');
    }
}

