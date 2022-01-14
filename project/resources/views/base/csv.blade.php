@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Base -> CSV</div>

                <div class="card-body">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <textarea class="description" name="description" readonly>
                     <?php   
                              $chaves =array_keys($dados[0]);
                             

                              for($i=0;$i<count($dados);$i++){
                                      for($k=0;$k<count($chaves);$k++){
                                        if($k==count($chaves)-1){
                                            echo ($dados[$i][$chaves[$k]]."");
                    
                                        }else{
                                            echo ($dados[$i][$chaves[$k]].",");
                    
                                        }
                                      }
                                      echo "<br/>";
                              }
                        ?>
                    </textarea>
                    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                    <script>
                        tinymce.init({
                            selector:'textarea.description'
                           
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection