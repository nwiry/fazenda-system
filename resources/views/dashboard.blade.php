@extends('base')

@section('extra_head_contents')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
@endsection

@section('conteudo')
<div class="col-lg-12">
    <div class="card">
        <h5 class="card-header">Relatórios</h5>
        <div class="card-body">
            <ul>
                <li>Quantidade de leite produzida por semana: {{$nums_cattle['num_milk']}}ℓ</li>
                <li>Número de animais abatidos: {{$nums_cattle['slaughters']}}</li>
                <li>Número de ração necessária por semana: {{$nums_cattle['num_feed']}}kg</li>
            </ul>
        </div>
    </div>
</div>
<div style="margin-top: 25px;">
    <div class="col-lg-12">
        <div class="card">
            <h5 class="card-header">Animais disponíveis para abate</h5>
            <div class="card-body">
                <table id="table_animals_slaughters" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Produção de Leite (Semanal)</th>
                            <th>Ração Ingerida (Semanal)</th>
                            <th>Peso</th>
                            <th>Nascimento</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_body_contents')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<script type="text/javascript">
$.fn.dataTable.ext.errMode = 'console';
let table = $('#table_animals_slaughters').DataTable({
    responsive: true,
    "stripeClasses": [],
    "ajax": "/api/v1/list_slaughters",
    "processing": true,
    "serverSide": false,
    "paging": true,
    "columns": [{
        "data": "code"
    }, {
        "data": "milk"
    }, {
        "data": "feed"
    }, {
        "data": "weight"
    }, {
        "data": "full_date"
    }],
    "order": [
        [0, "desc"]
    ],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "orderMulti": false,
    "info": true,
    "autoWidth": false,
    "language": {
        "processing": "Processando...",
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "Não foram encontrados resultados",
        "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "search": "Buscar:",
        "infoEmpty": "Mostrando de 0 até 0 de 0 registros",
        "sInfoFiltered": "",
        "sInfoPostFix": "",
        "url": "",
        "loadingRecords": "Carregando...",
        "paginate": {
            "first": "Primeiro",
            "previous": "Anterior",
            "next": "Seguinte",
            "last": "Último"
        }
    }
})
new $.fn.dataTable.FixedHeader(table);
</script>
@endsection