@extends('base')

@section('extra_head_contents')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css"
    integrity="sha512-6nOurLM21AN0pjGZk4IkBi49U2SRyM9dQXcuXoSYoV25l4I5/XslFQxClZy6fupHYJnAci7Iz3kF+j3+4aW7Jw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('conteudo')
<div class="col-lg-12">
    <div class="card">
        <h5 class="card-header">Editar Animal - {{$cattleInfo->code}}</h5>
        <div class="card-body">
            <form action="javascript:void(0)" id="edit_cattle_form">
                <div class="mb-3">
                    <label for="cattle_code" class="form-label">Código da cabeça de gado</label>
                    <input type="text" class="form-control" id="cattle_code" value="{{$cattleInfo->code}}"
                        name="cattle_code" disabled>
                </div>
                <div class="mb-3">
                    <label for="cattle_milk" class="form-label">Quantidade de leite produzida (semanalmente)</label>
                    <input type="number" step="0.01" class="form-control" id="cattle_milk"
                        placeholder="Digite aqui a quantidade em litros" value="{{$cattleInfo->milk}}"
                        name="cattle_milk">
                </div>
                <div class="mb-3">
                    <label for="cattle_feed" class="form-label">Quantidade de ração consumida (semanalmente)</label>
                    <input type="number" step="0.01" class="form-control" id="cattle_feed"
                        placeholder="Digite aqui a quantidade em quilos" value="{{$cattleInfo->feed}}"
                        name="cattle_feed">
                </div>
                <div class="mb-3">
                    <label for="cattle_weight" class="form-label">Peso</label>
                    <input type="number" step="0.01" class="form-control" id="cattle_weight"
                        placeholder="Digite aqui o valor em quilos" value="{{$cattleInfo->weight}}"
                        name="cattle_weight">
                </div>
                <div class="mb-3">
                    <label for="birth_month" class="form-label">Mês de Nascimento</label>
                    <input type="number" min="1" max="12" class="form-control" value="{{$cattleInfo->birth_month}}"
                        id="birth_month" name="birth_month" disabled>
                </div>
                <div class="mb-3">
                    <label for="birth_year" class="form-label">Ano de Nascimento</label>
                    <input type="number" class="form-control" id="birth_year" name="birth_year"
                        value="{{$cattleInfo->birth_year}}" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Editar Animal</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('extra_body_contents')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"
    integrity="sha512-CnDb81AlCV0p3DBIJpm7x+ZZ7Vp6wusdxfk2451JmXe1pxYAEehEoUwdOhIIQ9WyEEWrhzZ0D7udW8rnLUz84g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
document.getElementById('edit_cattle_form').addEventListener('submit', function() {

    let cattle_code = document.getElementById('cattle_code').value,
        cattle_milk = document.getElementById('cattle_milk').value,
        cattle_feed = document.getElementById('cattle_feed').value,
        cattle_weight = document.getElementById('cattle_weight').value,
        btnSubmit = document.querySelector('.btn-primary'),
        query = location.search.slice(1),
        partes = query.split('&'),
        getdata = {};

    partes.forEach(function(parte) {
        let chaveValor = parte.split('='),
            chave = chaveValor[0],
            valor = chaveValor[1];
        getdata[chave] = valor;
    });

    if (!cattle_milk.trim().length) return swal('Quantidade de leite produzido não informado',
        'Você precisa informar o a quantidade de leite que esse animal produz semanalmente!', 'error');
    if (!cattle_feed.trim().length) return swal('Quantidade de ração consumida não informada',
        'Você precisa informar a quantidade de ração que esse animal consome semanalmente!', 'error');
    if (!cattle_weight.trim().length) return swal('Peso do animal não informado',
        'Você precisa informar o peso do animal!', 'error');

    btnSubmit.innerHTML = 'Aguarde...', btnSubmit.disabled = true;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        crossDomain: !0,
        cache: !1,
        url: "/api/v1/edit_cattle",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cattle_id: getdata["cattle_id"],
            cattle_milk: cattle_milk,
            cattle_feed: cattle_feed,
            cattle_weight: cattle_weight
        },
        dataType: "json",
        success: function(data) {
            if (data.status == 'success') {
                btnSubmit.innerHTML = 'Atualizando...';
                swal({
                        title: 'Operação bem-sucedida!',
                        text: 'O animal ' + cattle_code + ' foi atualizado com sucesso!',
                        type: 'success',
                        showConfirmButton: false
                    }),
                    setTimeout(function() {
                        window.location.href = '/list_cattle';
                    }, 1200);
            } else {
                btnSubmit.innerHTML = 'Editar Animal', btnSubmit.disabled = false;
                swal('Falha na operação',
                    'Ocorreu um erro ao editar o animal.<br>Código de erro: ' + data
                    .response, 'error');
            }
        },
        error: function(error) {
            btnSubmit.innerHTML = 'Editar Animal', btnSubmit.disabled = false;
            console.log(error)
            swal('Falha na requisição',
                'Ocorreu um erro ao se comunicar com a API. Tente novamente mais tarde.',
                'warning');
        }
    })
})
</script>
@endsection