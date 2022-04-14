<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/dt-1.10.9/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/dt-1.10.9/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('transaction.transactions')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="background-color:#cfcfcf; padding:5px; border-radius: 5px;">
                <div style="display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; margin:10px 0px 13px 10px;">
                    <div>
                        <h1 style="font-size:24px;font-weight:bold;">@lang('transaction.transactions')</h1>
                    </div>
                    <div>
                        <a class="bg-light" href="{{ route('import-transaction') }}" > <i class="fas fa-cloud-upload-alt"></i> @lang('form.import')</a>
                        <a class="bg-success" href="{{ route('add-transaction') }}" > <i class="fas fa-plus-circle"></i> @lang('form.new')</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm" style="padding-bottom:10px;padding-top:10px;">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>@lang('transaction.movement')</th>
                                <th>@lang('transaction.code')</th>
                                <th>@lang('transaction.date')</th>
                                <th>@lang('transaction.amount')</th>
                                <th>@lang('transaction.price')</th>
                                <th>@lang('transaction.total')</th>
                                <th style="width:50px;">@lang('form.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>@lang('transaction.movements.' . $transaction->movement)</td>
                                <td>{{ $transaction->code }}</td>
                                <td>{{ date("d/m/Y", strtotime($transaction->date)) }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>R$ {{ str_replace('.', ',', $transaction->price) }}</td>
                                <td>R$ {{ str_replace('.', ',', $transaction->total) }}</td>
                                <td>
                                    <div class="row-2" style="font-size:20px; text-align:center;">
                                        <a href="{{ route('edit-transaction' , $transaction->uuid) }}"><i class="fas fa-edit txt-success"></i></a>

                                        <form id="delete_student" action="{{ route('destroy-transaction' , $transaction->uuid) }}" method="post" style="width:22px;">
                                            @csrf
                                            <button type="submit" class="show_confirm" data-toggle="tooltip" title='Delete'><i class="fas fa-trash txt-error"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; margin:10px;">
                    <div>
                        <h3>@lang('transaction.transactions')</h3>
                    </div>
                    <div>
                        <a style="background-color:green; color:white; border:darkgreen; border-radius:10px; padding:10px;">@lang('form.new')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });

        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal.fire({
                title: '@lang('form.want_delete')',
                text: '@lang('form.if_delete')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('form.yes_delete')'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

@if(session('message'))
    <script>
        toastr.{{ session('message')['class'] }}('{{ session('message')['message'] }}');
    </script>
@endif

</x-app-layout>
