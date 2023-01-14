<div class="col-md-12">
    <div class="card card-primary card-outline">
        <h5 class="card-header">
            Remetente: {{$message->getFrom()->getAddress()}}
        </h5>
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5> Assunto: {{$message->getSubject()}}</h5>
                <span class="mailbox-read-time float-right"> {{$message->getDate()->format('d/m/Y')}}</span></h6>
            </div>
        </div>

        <div class="mailbox-read-message">
            <h5>Conteudo: </h5>
            <p> {!! $message->getBodyHtml() !!}</p>
        </div>
    </div>
    <div class="card-footer bg-white">
        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
            @if ($attachments != 0)
                @foreach ($attachments as $attachment)
                    <li>
                        <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                        <p>{{ $attachment->getFilename() }}</p>
                        <a href="#" class="download-attachment" data-email-id="{{$message->getNumber()}}"
                           data-attachment-content="{{ $attachment->getDecodedContent() }}">Download Attachment</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="attach" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?php
                    //  Storage::put($attachment->getFilename(), $attachment->getDecodedContent());
                    ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Criar
    Processo
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Novo Processo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('meusprocessos.save')}}">
                    @csrf
                    <div class="form-group">
                        <label class="col-form-label"> Nome:</label>
                        <input name="nome" type="text" class="form-control" value="" placeholder="Nome" id="nome"
                               required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"> Descrição:</label>
                        <textarea name="descricao" class="form-control" value="" id="descricao" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"> Funcionário</label>
                        <select name="funcionario" class="form-select" aria-label="Default select example" required>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{$funcionario->id}}">{{$funcionario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label"> Departamento</label>
                        <select name="departamento" class="form-select" aria-label="Default select example" required>
                            @foreach($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{$departamento->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label"> Remetente:</label>
                        <input name="emailremetente" type="email" class="form-control" id="recipient-name"
                               value="{{$message->getFrom()->getAddress()}}"
                               placeholder="{{$message->getFrom()->getAddress()}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Assunto: </label>
                        <input name="assunto" class="form-control"
                               value="{{$message->getSubject()}}" placeholder="{{$message->getSubject()}}"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Conteudo: </label>
                        <textarea name="desenvolvimento" class="form-control" id="message-text"
                                  value="{{$message->getBodyText()}}"
                                  readonly>{{$message->getBodyText()}}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Criar Processo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.2.min.js"
        integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this)
    })
</script>

<script>
    $(document).ready(function() {
        $('.download-attachment').click(function(e) {
            e.preventDefault();
            var emailId = $(this).data('email-id');
            var attachmentContent = $(this).data('attachment-content');
            $.ajax({
                type: 'POST',
                url: '{{ route('download.attachment') }}',
                data: { email_id: emailId, attachment_content: attachmentContent },
                success: function(response) {
                    window.location = response.file;
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });
    });
</script>






