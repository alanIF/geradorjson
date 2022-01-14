@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header">Base -> JSON</div>

                <div class="card-body" >
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <textarea class="description" name="description" readonly>
                     <?php   
                             echo $dados;
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