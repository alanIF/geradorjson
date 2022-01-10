@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Base</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            @if(Request::is('*/edit'))
            <form action="{{url('base/update')}}/{{$base->id}}" method="post">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" name="nome" placeholder="nome" value="{{$base->nome}}" required>
            </div>
         
            <div class="mb-3">
                <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="{{$base->descricao}}" required>
            </div>
           
           

            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-warning " href="{{url('base/')}}">Voltar</a>

            </form>
            @endif
            @if(Request::is('*/new'))

            <form action="{{url('base/add')}}" method="post" enctype="multipart/form-data"> 
            @csrf
            
            <div class="mb-3">
                <input type="text" class="form-control" name="nome" placeholder="nome" required>
            </div>
         
            <div class="mb-3">
                <input type="text" class="form-control" name="descricao" placeholder="Descrição"  required>
            </div>
            <div class="mb-3">
                      <input type="file" name="file" class="form-control" placeholder="Choose file" id="file">
                        @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
        </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-warning " href="{{url('base/')}}">Voltar</a>

            
            </form>
            @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection