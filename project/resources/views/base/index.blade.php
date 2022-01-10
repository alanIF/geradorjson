@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bases</div>

                <div class="card-body">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover ">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">nome </th>

                            <th scope="col">descrição </th>

                            <th scope="col">arquivo csv </th>
                            

                            <th colspan='3'>Ações</th>
                            


                            </tr>
                        </thead>
                        <tbody>
                        @foreach($bases as $b)
                        <tr>

                            <td >{{$b->id}}</td>
                            <td>{{$b->nome}}</td>

                            <td>{{$b->descricao}}</td>
                            <td><a class="btn btn-info "  href="{{$b->arquivo_csv}}" target="_blank"><i class="fa fa-file"></i></a></td>


                            <td><a class="btn btn-warning " href="base/{{$b->id}}/edit"><i class="fa fa-database" ></i></a> </td>

                            <td><a class="btn btn-warning " href="base/{{$b->id}}/edit"><i class="fa fa-edit" ></i></a> </td>
                            <td>   <form action="base/delete/{{$b->id}}" method="post"> @csrf @method('delete')<button class="btn btn-danger"><i class="fa fa-trash" ></i></button></form></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr >
                                <td colspan='6'><a class="btn btn-primary " href="{{url('base/new')}}"><i class="fa fa-plus" ></i></a></td>
                            </tr>
                        </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection