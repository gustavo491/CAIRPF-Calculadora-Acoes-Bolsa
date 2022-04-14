<script src="{{ asset('js/jquery.min.js') }}"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}" defer></script>

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
                    @lang($transaction->title)
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div>
                        <form action="{{ route('save-transaction') }}" method="post" class="form-item">
                            @csrf
                            <div class="row-2">
                                <div class="w-50 pdr">
                                    <label class="form-group" for="select">@lang('transaction.movement')</label>
                                    <select class="form-itens" name="movement">
                                        <option value="buy" @if( !empty($transaction->movement) && 'buy' == $transaction->movement ) selected @endif>@lang('transaction.movements.buy')</option>
                                        <option value="sell" @if( !empty($transaction->movement) && 'sell' == $transaction->movement ) selected @endif>@lang('transaction.movements.sell')</option>
                                        <option value="rent" @if( !empty($transaction->movement) && 'rent' == $transaction->movement ) selected @endif>@lang('transaction.movements.rent')</option>
                                    </select>
                                </div>
                                <div class="w-50">
                                    <label class="form-group" for="select">@lang('transaction.code')</label>
                                    <select class="form-itens select2" name="code" class="meuselect">
                                        <option>@lang('form.select_option')</option>
                                        @foreach ($actives as $active)
                                            <option value="{{ $active->code }}" @if( !empty($transaction->code) && $active->code == $transaction->code  ) selected @endif>{{ $active->code }} - {{ $active->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row-3">
                                <div class="w-50 pdr">
                                    <label class="form-group" for="date">@lang('transaction.date')</label>
                                    <input class="form-itens" type="date" name="date" value="{{ ( !empty($transaction->date) ) ? $transaction->date : '' }}">
                                </div>
                                <div class="w-50 pdr">
                                    <label class="form-group" for="amount">@lang('transaction.amount')</label>
                                    <input class="form-itens" name="amount" type="number" placeholder="000" value="{{ !empty($transaction->amount)? $transaction->amount : '' }}">
                                </div>
                                <div class="w-50">
                                    <label class="form-group" for="price">@lang('transaction.price')</label>
                                    <input type="text" class="money form-itens" name="price" placeholder="R$ 0,00" value="{{ !empty($transaction->price)? str_replace('.',',', $transaction->price) : '' }}">
                                </div>
                            </div>
                            <div class="row-3">
                                <div class="w-50 pdr">
                                    <label class="form-group" for="total">@lang('transaction.total')</label>
                                    <input type="text" class="money form-itens" name="total" id="total" placeholder="R$ 0,00" value="{{ !empty($transaction->total)? str_replace(".",",",$transaction->total) : '' }}">
                                </div>
                            </div>
                            <div class="form-buttons">
                                <button class="bg-success" type="submit">@lang($transaction->action)</button>
                                <a href="{{ route('transactions') }}">
                                    <button class="bg-error" type="button">@lang('form.cancel')</button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });

        $(function(){
            $(".money").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
            document.getElementsByName("total")[0].focus();
            document.getElementsByName("price")[0].focus();
            document.getElementsByName("movement")[0].focus();
        })
    </script>
</x-app-layout>
