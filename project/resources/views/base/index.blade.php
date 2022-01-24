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
                    <input class="form-control" id="myInput" type="text" placeholder="Search..">

                    <table class="table table-hover ">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">nome </th>

                            <th scope="col">descrição </th>

                            

                            <th colspan='5'>Ações</th>
                            


                            </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach($bases as $b)
                        <tr>

                            <td >{{$b->id}}</td>
                            <td>{{$b->nome}}</td>

                            <td>{{$b->descricao}}</td>
                            <td><a class="btn btn-info " href="base/{{$b->id}}/gerar_csv"><i class="fa fa-file" alt="arquivo csv"></i></a> </td>


                            <td><a class="btn btn-warning " href="base/{{$b->id}}/gerar_json"><i class="fa fa-server" alt="Gerar json" ></i></a> </td>
                            <td><a class="btn btn-info " href="base/{{$b->id}}/gerar_sql"><i class="fa fa-database" alt="Gerar sql" ></i></a> </td>

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
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection