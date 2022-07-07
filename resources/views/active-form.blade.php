<script src="{{ asset('js/jquery.min.js') }}"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="element-header">
                    @lang($active->title)
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div>
                        <form action="{{ route($active->route, !empty($active->uuid) ? $active->uuid : '') }}" method="post" class="form-item">
                            @csrf
                            <div class="row-2">
                                <div class="w-50 pdr">
                                    <label class="form-group" for="code">@lang('active.code')</label>
                                    <input class="form-itens" type="text" name="code" placeholder="@lang('active.code')" value="{{ ( !empty($active->code) ) ? $active->code : '' }}">
                                </div>
                                <div class="w-50 pdr">
                                    <label class="form-group" for="name">@lang('active.name')</label>
                                    <input class="form-itens" name="name" type="text" placeholder="@lang('active.name')" value="{{ !empty($active->name)? $active->name : '' }}">
                                </div>
                            </div>
                            <div class="row-1">
                                <div class="w-50 pdr">
                                    <label class="form-group" for="cnpj">@lang('active.cnpj')</label>
                                    <input type="text" class="form-itens" name="cnpj" placeholder="XX. XXX. XXX/0001-XX." value="{{ !empty($active->cnpj)? $active->cnpj : '' }}">
                                </div>
                            </div>
                            <div class="form-buttons">
                                <button class="bg-success" type="submit">@lang($active->action)</button>
                                <a href="{{ route('actives') }}">
                                    <button class="bg-error" type="button">@lang('form.cancel')</button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
