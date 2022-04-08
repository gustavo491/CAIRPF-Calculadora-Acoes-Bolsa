<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('transaction.transactions')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="background-color:darkgrey;padding:5px;">
                <div style="display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; margin:10px;">
                    <div>
                        <h3>@lang('transaction.transactions')</h3>
                    </div>
                    <div>
                        <a style="background-color:green; color:white; border:darkgreen; border-radius:10px; padding:5px;">@lang('form.new')</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table>
                        <tr>
                            <th>@lang('transaction.movement')</th>
                            <th>@lang('transaction.code')</th>
                            <th>@lang('transaction.date')</th>
                            <th>@lang('transaction.amount')</th>
                            <th>@lang('transaction.price')</th>
                            <th>@lang('transaction.total')</th>
                            <th>@lang('form.actions')</th>
                        </tr>
                        <tr>
                            <td>Venda</td>
                            <td>Maria Anders</td>
                            <td>Germany</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</x-app-layout>
