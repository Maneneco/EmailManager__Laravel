@if( Auth::user()->nivelpermissao_id == 1)
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <!--{{ __('You are logged in!') }}-->

    @extends('adminlte::page')

    @section('title', 'Dashboard')

    @section('content')
        <div class="row m-1 mt-3">
            <div class="col-md-3">
                <a id="refreshEmails" class="btn btn-primary btn-block mb-3" data-toggle="modal"
                   data-target="#criarFuncionario">Novo Funcionario </a>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Departamentos</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a style="cursor: pointer;" id="todos" class="nav-link">
                                    <i class=""></i> Todos
                                </a>
                            </li>
                            @foreach($departamentos as $departamento)
                                <li class="nav-item">
                                    <a style="cursor: pointer;" id="{{$departamento->id}}" class="nav-link">
                                        <i class=""></i> {{$departamento->nome}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input type="text" name="search" class="form-control input-sm" id="search" value=""
                               placeholder="Procurar Funcionário pelo nome">
                    </div>
                </div>
                <div id='funcionarios'>
                </div>
            </div>
        </div>

        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

        <script>

            var isEmailOpen = 1

            @foreach($departamentos as $departamento)
            $("#{{$departamento->id}}").on('click', function () {

                $("#funcionarios").html("<img src=' https://flevix.com/wp-content/uploads/2019/07/Curve-Loading.gif' >")
                $("#funcionarios").load("{!! route('admin.funcionarios.filtro') !!}/{!! $departamento->identificador !!}" )
                isEmailOpen = 0
            });
            @endforeach

            $("#todos").on('click', function () {
                $("#funcionarios").html("<img src=' https://flevix.com/wp-content/uploads/2019/07/Curve-Loading.gif' >")
                $("#funcionarios").load("{!! route('admin.funcionarios')!!}")
                isEmailOpen = 1
            });

            $(document).on('click', 'a.verFuncionario', function (e) {
                var id = $(this).attr("data-id")
                // console.log(id);
                $("#funcionarios").html("<img src=' https://flevix.com/wp-content/uploads/2019/07/Curve-Loading.gif' >")
                $("#funcionarios").load("{!! route('admin.funcionario') !!}" + "/" + id)
                isEmailOpen = 0
            });

            $("#funcionarios").html("<img src=' https://flevix.com/wp-content/uploads/2019/07/Curve-Loading.gif' >")
            $("#funcionarios").load("{!! route('admin.funcionarios') !!}")

            $("#search").on("keyup", function (e) {
                isEmailOpen = 0
                var val = $.trim(this.value);
                if (e.key === 'Backspace') {
                    $("#funcionarios").load("{!! route('admin.funcionariosSearch') !!}/" + val)
                }
                $("#funcionarios").load("{!! route('admin.funcionariosSearch') !!}/" + val)
            });

            $(document).ready(function() {
                setInterval(function() {
                    if (isEmailOpen==1) {
                        $("#emails").load("{!! route('mailbox.emails') !!}");
                    }
                }, 50000); // 1 minute
            });
        </script>

        <div class="modal fade" id="criarFuncionario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Criar Funcionário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" method="post" action="{{route('funcionario.save')}}">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Username:</label>
                                <input autocomplete="false" name="username" type="text" class="form-control" value=""
                                       id="username"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input autocomplete="false" name="password" type="password" class="form-control"
                                       id="password"
                                       placeholder="Password" minlength="8" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Nome Completo:</label>
                                <input name="name" type="text" class="form-control" value="" id="nomecompleto"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> E-mail:</label>
                                <input name="email" type="email" class="form-control" value="" id="email"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="permissao" class="col-form-label font-weight-bold">Nível de Permissão</label>
                                <select name="permissao" id="permissao" class="form-control" required>
                                    @foreach($permissoes as $permissao)
                                        <option value="{{$permissao->id}}">{{$permissao->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="departamento" class="col-form-label font-weight-bold">Departamento</label>
                                <select name="departamento" id="departamento" class="form-control" required>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{$departamento->id}}">{{$departamento->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Criar Funcionario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @stop
@endif
