@extends('base')

@section('extra_head_contents')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css"
    integrity="sha512-6nOurLM21AN0pjGZk4IkBi49U2SRyM9dQXcuXoSYoV25l4I5/XslFQxClZy6fupHYJnAci7Iz3kF+j3+4aW7Jw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('conteudo')
<div class="col-lg-12">
    <div class="card">
        <h5 class="card-header">Cadastrar Animal</h5>
        <div class="card-body">
            <form action="javascript:void(0)" id="register_cattle_form">
                <div class="mb-3">
                    <label for="cattle_code" class="form-label">Código da cabeça de gado</label>
                    <input type="text" class="form-control" id="cattle_code"
                        placeholder="Ex: {{strtoupper(Nette\Utils\Random::generate(rand(7,12)))}}" name="cattle_code">
                </div>
                <div class="mb-3">
                    <label for="cattle_milk" class="form-label">Quantidade de leite produzida (semanalmente)</label>
                    <input type="number" step="0.01" class="form-control" id="cattle_milk"
                        placeholder="Digite aqui a quantidade em litros" name="cattle_milk">
                </div>
                <div class="mb-3">
                    <label for="cattle_feed" class="form-label">Quantidade de ração consumida (semanalmente)</label>
                    <input type="number" step="0.01" class="form-control" id="cattle_feed"
                        placeholder="Digite aqui a quantidade em quilos" name="cattle_feed">
                </div>
                <div class="mb-3">
                    <label for="cattle_weight" class="form-label">Peso</label>
                    <input type="number" step="0.01" class="form-control" id="cattle_weight"
                        placeholder="Digite aqui o valor em quilos" name="cattle_weight">
                </div>
                <div class="mb-3">
                    <label for="birth_month" class="form-label">Mês de Nascimento</label>
                    <input type="number" min="1" max="12" class="form-control" placeholder="Ex: {{rand(1,12)}}"
                        id="birth_month" name="birth_month">
                </div>
                <div class="mb-3">
                    <label for="birth_year" class="form-label">Ano de Nascimento</label>
                    <input type="number" placeholder="Ex: {{rand(1990,date('Y'))}}" min="1990" max="{{date('Y')}}"
                        class="form-control" id="birth_year" name="birth_year">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Animal</button>
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
document.getElementById('register_cattle_form').addEventListener('submit', function() {

    let cattle_code = document.getElementById('cattle_code').value,
        cattle_milk = document.getElementById('cattle_milk').value,
        cattle_feed = document.getElementById('cattle_feed').value,
        cattle_weight = document.getElementById('cattle_weight').value,
        birth_month = document.getElementById('birth_month').value,
        birth_year = document.getElementById('birth_year').value,
        btnSubmit = document.querySelector('.btn-primary');

    if (!cattle_code.trim().length) return swal('Código de cabeça de gado não infomado',
        'Você precisa informar o código da cabeça de gado!', 'error');
    if (!cattle_milk.trim().length) return swal('Quantidade de leite produzido não informado',
        'Você precisa informar o a quantidade de leite que esse animal produz semanalmente!', 'error');
    if (!cattle_feed.trim().length) return swal('Quantidade de ração consumida não informada',
        'Você precisa informar a quantidade de ração que esse animal consome semanalmente!', 'error');
    if (!cattle_weight.trim().length) return swal('Peso do animal não informado',
        'Você precisa informar o peso do animal!', 'error');
    if (!birth_month.trim().length) return swal('Mês de nascimento não informado',
        'Você precisa informar o mês de nascimento do animal!', 'error');
    if (!birth_year.trim().length) return swal('Ano de nascimento não informado',
        'Você precisa informar o ano de nascimento do animal!', 'error');

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
        url: "/api/v1/register_cattle",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cattle_code: cattle_code,
            cattle_milk: cattle_milk,
            cattle_feed: cattle_feed,
            cattle_weight: cattle_weight,
            cattle_birth_month: birth_month,
            cattle_birth_year: birth_year
        },
        dataType: "json",
        success: function(data) {
            if (data.status == 'success') {
                btnSubmit.innerHTML = 'Redirecionando...';
                swal({
                        title: 'Operação bem-sucedida!',
                        text: 'O animal ' + cattle_code + ' foi cadastrado com sucesso!',
                        type: 'success',
                        showConfirmButton: false
                    }),
                    setTimeout(function() {
                        window.location.href = '/list_cattle';
                    }, 1200);
            } else {
                btnSubmit.innerHTML = 'Cadastrar Animal', btnSubmit.disabled = false;
                swal('Falha na operação',
                    'Ocorreu um erro ao cadastrar o animal.<br>Código de erro: ' + data
                    .response, 'error');
            }
        },
        error: function(error) {
            btnSubmit.innerHTML = 'Cadastrar Animal', btnSubmit.disabled = false;
            console.log(error)
            swal('Falha na requisição',
                'Ocorreu um erro ao se comunicar com a API. Tente novamente mais tarde.',
                'warning');
        }
    })
})
</script>
@endsection