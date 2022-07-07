<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            .img2 {
                float: left;
            }
            th, td {
                border: 1px solid black;
            }
            @page { margin: 25px; }
        </style>
    </head>
    <body>
        <div style="padding-bottom:5px;">
            <table>
                <tr>
                    <th style="width:50%; text-align:center;">
                        <img style="padding-right:20px;" class="img2" src="{{ asset('images/brasao.png') }}" alt="Pineapple" width="75" height="75">
                        <span style="font-size:13px;">MINISTÉRIO DA ECONOMIA</span><br>
                        <span style="font-size:11px; font-weight:350;">Secretaria Especial da Receita Federal do Brasil</span><br>
                        <span style="font-size:10px; font-weight:700;">Imposto Sobre a Renda da Pessoa Física</span><br>
                        <span style="font-size:11px; font-style: italic;">Exercício de 2022</span>
                    </th>
                    <th style="width:50%;">
                        <div style="display:block;text-align:center;padding-left:-20%">
                            <span style="font-size:11px; font-weight:350; text-align:center;">Comprovante de Rendimentos Pagos e de</span><br>
                            <span style="font-size:11px; font-weight:350;">Imposto sobre a Renda Retido na Fonte</span><br><br>
                            <span style="font-size:11px; font-style: italic;">Ano-calendário de 2021</span>
                        </div>
                    </th>
                </tr>
            </table>
        </div>
        <div style="padding:2px; border: 1px solid black;width:80%; margin: auto;">
            <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;">Verifique as condições e o prazo para a apresentação da Declaração do Imposto sobre a Renda da Pessoa Física para este ano-calendário no sítio da Secretaria Especial da Receita Federal do Brasil na Internet, no endereço &#60receita.economia.gov.br&#62.</span>
        </div>
        <span style="font-size:14px; font-family: Arial, Helvetica, sans-serif;font-weight:bold;">1. Fonte Pagadora Pessoa Jurídica</span>
        <table style="padding:2px; border: 1px solid black;width:100%; margin: auto;padding-bottom:15px">
            <tr>
                <th style="width:30%;">
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">CNPJ</span>
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">30.000.000/0001-01</span>
                </th>
                <th style="width:70%;">
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">Nome Empresarial</span>
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">EMPRESA FICTICIA DE TESTE</span>
                </th>
            </tr>
        </table>

        <span style="font-size:14px; font-family: Arial, Helvetica, sans-serif;font-weight:bold;">2. Pessoa Física Beneficiária dos Rendimentos</span>
        <table style="padding:2px; border: 1px solid black;width:100%; margin: auto;padding-bottom:15px">
            <tr>
                <th style="width:30%;">
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">CPF</span>
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">{{ $user->cpf }}</span>
                </th>
                <th style="width:70%;">
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">Nome Completo</span>
                    <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;">{{ $user->name }}</span>
                </th>
            </tr>
        </table>

        <span style="font-size:14px; font-family: Arial, Helvetica, sans-serif;font-weight:bold;padding-top:15px;">3. Declaração de Bens e Direitos final (Valores em Reais)</span>
        <table style="padding:2px; border: 1px solid black;width:100%; margin: auto;">
            <tr style="font-size:11px;">
                <th style="width:5%;">GRUPO</th>
                <th style="width:5%;">CÓDIGO</th>
                <th style="width:50%;">DISCRIMINAÇÃO</th>
                <th style="width:40%;text-align:center;">SITUAÇÃO EM
                    <table style="margin-bottom:-13px;">
                        <tr style="border:none !important;">
                            <th style="border:none !important;text-align:center;">
                                <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;font-weight:400;">31/12/2020</span>
                            </th>
                            <th style="border:none !important;text-align:center;">
                                <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;font-weight:400;">31/12/2020</span>
                            </th>
                        </tr>
                    </table>
                </th>
            </tr>
            @foreach ($dataItens as $itens)
            <tr style="font-size:10.3px;">
                <td>03</td>
                <td>01</td>
                <td>
                    {{ $itens['amount'] }} ações da {{ $itens['name'] }} ({{ $itens['code'] }}) - CNPJ: {{ $itens['cnpj'] }}, {{ $itens['broker'] }}
                </td>
                <td>
                    <table>
                        <tr style="border:none !important;">
                            <th style="border:none !important;text-align:center;">
                                <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;font-weight:400;">{{ $itens['startValue'] }}</span>
                            </th>
                            <th style="border:none !important;text-align:center;">
                                <span style="font-size:10.3px; font-family: Arial, Helvetica, sans-serif;display:block;font-weight:400;">{{ $itens['endValue'] }}</span>
                            </th>
                        </tr>
                    </table>
                </td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
