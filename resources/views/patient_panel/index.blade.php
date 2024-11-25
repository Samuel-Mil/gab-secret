<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{getenv('APP_URL')}}/css/financial.css">
    <script defer src="https://kit.fontawesome.com/708b4765cf.js" crossorigin="anonymous"></script>
    <title>Painel do paciente</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header class="main_header" style="width: 100%;">
        <h1>Painel do paciente</h1>
        <div class="buttons_box">
            <a href="{{route('logout')}}"><i class="fa-solid fa-right-from-bracket" title="logout"></i></a>
        </div>
    </header>

    <section class="gabs">
        <h1 class="page_title" style="color: #444;margin:15px 0;padding: 10px;">GABs de {{auth()->user()->name}}</h1>
        <table class="dash_table">
        <thead class="dash_table_header">
            <tr class="">
                <th>ID</th>
                <th>Status</th>
                <th>Clínica</th>
                <th>Mensagem</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($requests as $req)
        @if (isset($gabs[$req->id])) <!-- Verifica se há gabs para o request atual -->
            @foreach ($gabs[$req->id] as $gab) <!-- Itera sobre os gabs relacionados -->
                <tr class="dash_table_column">
                    <td>{{ $gab['id'] }}</td>
                    @if ($gab['status'] == 'pendente')
                        <td class="tipo_alerta">{{ strtoupper($gab->status) }}</td>
                    @elseif ($gab['status'] == 'emitida')
                        <td class="tipo_entrada">{{ strtoupper($gab->status) }}</td>
                    @elseif ($gab['status'] == 'negada')
                        <td class="tipo_saida">{{ strtoupper($gab->status) }}</td>
                    @endif
                    <!-- Obtendo o nome da clínica usando o clinic_id do request atual -->
                    <td>{{ $clinics[$req->clinic_id]->name ?? 'Clinica Indefinida' }}</td>
                    @if ($gab['status'] == 'negada')
                        <td>{{ $gab['status'] }}</td>
                    @else
                        <td>----------</td>
                    @endif
                    @if ($gab['status'] == 'emitida')
                        <td><a href="{{ route('download', $gab->id) }}">Download</a></td> 
                    @else
                        <td><p style="cursor: not-allowed;">Indisponivel</p></td>     
                    @endif
                </tr>
            @endforeach
        @endif
    @endforeach
</tbody>
    </table>
    </section>
</body>
</html>