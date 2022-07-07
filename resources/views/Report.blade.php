<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table>
                        <thead>
                            <tr>
                                <th>@lang('form.name')</th>
                                <th>@lang('report.year')</th>
                                <th style="text-align:center;">@lang('form.actions')</th>
                            </tr>   
                        </thead>
                        <tbody>
                            <tr>
                                <td>@lang('report.assets')</td>
                                <td>
                                    <select class="form-itens" id="year" onchange="changeYear();">
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="row-3" style="text-align:center;">
                                        <form action="{{ route('preview-report') }}" method="post" class="form-max">
                                            @csrf
                                            <button class="bg-light form-max" type="submit" class="show_confirm" data-toggle="tooltip" title='Delete'><i class="fas fa-eye"></i> @lang('report.preview')</button>
                                        </form>

                                        <form action="{{ route('excel-report') }}" method="post" class="form-max">
                                            @csrf
                                            <button class="bg-success form-max" type="submit" class="show_confirm" data-toggle="tooltip" title='Delete'><i class="fas fa-file-excel"></i> @lang('report.excel')</button>
                                        </form>
                                        
                                        <form action="{{ route('pdf-report') }}" method="post" class="form-max">
                                            @csrf
                                            <input type="hidden" id="yearSelected" name="year" value="2018">
                                            <button class="bg-error form-max" type="submit" class="show_confirm" data-toggle="tooltip" title='Delete'><i class="fas fa-file-pdf"></i> @lang('report.pdf')</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function changeYear(){
        document.getElementById('yearSelected').value = document.getElementById('year').value;
    }
</script>
