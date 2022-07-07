<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Actives;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actives = actives::get();
        $transactions = transactions::where('id_user', auth()->user()->id)->get();
        foreach($transactions as $transaction) {
            foreach($actives as $active) {
                if( $active->id == $transaction->id_active ) {
                    $transaction->code = $active->code;
                }
            }
        }
        return view('transaction', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actives = actives::get();
        $transaction = new \stdClass;
        $transaction->title = "transaction.add_transaction";
        $transaction->action = "form.add";
        $transaction->route = 'save-transaction';

        return view('transaction-form', ['actives' => $actives, 'transaction' => $transaction]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();

        $transaction = new Transactions;
        $transaction->uuid = Str::uuid();
        $transaction->id_user = auth()->user()->id;

        foreach($formData as $column => $data){
            if($column != "_token"){
                if($column == 'price' || $column == 'total'){
                    $data = $this->moneyFormat($data);
                }
                $transaction->$column  = $data;
            }
        }

        if($transaction->save()){
            return redirect()->route('transactions')->with('message',  ['message' => __('form.register_success'), 'class' => 'success']);
        } else{
            return redirect()->route('transactions')->with('message',  ['message' => __('form.register_error'), 'class' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $transaction = transactions::where('uuid', $uuid)->where('id_user', auth()->user()->id)->firstOrFail();
        
        if(!empty($transaction)){
            $actives = actives::get();
            $transaction->title = "transaction.edit_transaction";
            $transaction->action = "form.edit";
            $transaction->route = "update-transaction";
        } else{
            return redirect()->route('transactions')->with('message',  ['message' => __('form.register_undefined'), 'class' => 'error']);
        }
        return view('transaction-form', ['transaction' => $transaction, 'actives' => $actives]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $formData = $request->all();
        $transaction = new Transactions;

        unset($formData['_token']);
        $formData['price'] = $this->moneyFormat($formData['price']);
        $formData['total'] = $this->moneyFormat($formData['total']);

        if($transaction::where('uuid', $uuid)->where('id_user', auth()->user()->id)->update($formData)) {
            return redirect()->route('transactions')->with('message',  ['message' => __('form.update_success'), 'class' => 'success']);
        } else{
            return redirect()->route('transactions')->with('message',  ['message' => __('form.update_error'), 'class' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        if(transactions::where('uuid', $uuid)->where('id_user', auth()->user()->id)->delete()){
            return redirect()->route('transactions')->with('message',  ['message' => __('form.delete_success'), 'class' => 'success']);
        } else{
            return redirect()->route('transactions')->with('message',  ['message' => __('form.delete_error'), 'class' => 'error']);
        }
    }

    /**
     * Money format to database. 
     * 
     * @param  int  $data
     **/
    public function moneyFormat($data)
    {
        return trim(str_replace(',','.', str_replace('.','', str_replace('R$','', $data))));
    }

    /**
     * Import from excel to database;
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $handle = fopen($request->file, "r");
        while (($line = fgetcsv($handle)) !== false)
        {
            $meuArray[] = $line;
        }
        $index = array();
        foreach($meuArray[0] as $key => $row){
            switch ($row) {
                case 'Data do Negócio':
                    $index['date'] = $key;
                    break;
                case 'Tipo de Movimentação':
                    $index['movement'] = $key;
                    break;
                case 'Mercado':
                    break;
                case 'Prazo/Vencimento':
                    break;
                case 'Instituição':
                    $index['broker'] = $key;
                    break;
                case 'Código de Negociação':
                    $index['code'] = $key;
                    break;
                case 'Quantidade':
                    $index['amount'] = $key;
                    break;
                case 'Preço':
                    $index['price'] = $key;
                    break;
                case 'Valor':
                    $index['total'] = $key;
                    break;
            }
        }
        array_shift($meuArray);

        $actives = actives::get();

        $active = array();
        foreach ($actives as $key => $data) {
           $active[$data->code] = $data->id;
        }
        $empty = array();
        foreach ($meuArray as $key => $row) {
            $transaction[$key] = new Transactions;
            $transaction[$key]->uuid = Str::uuid();
            $transaction[$key]->id_user = auth()->user()->id;
            $transaction[$key]->date = date("Y-m-d", strtotime(str_replace("/", "-", $row[$index['date']])));
            $transaction[$key]->movement = $this->pickMovement($row[$index['movement']]);
            $transaction[$key]->broker = $row[$index['broker']];
            $transaction[$key]->amount = $row[$index['amount']];
            $transaction[$key]->price = $this->moneyFormat($row[$index['price']]);
            $transaction[$key]->total = $this->moneyFormat($row[$index['total']]);
            if (empty($active[$row[$index['code']]])) {
                $empty[] = $row[$index['code']];
            } else {
                $transaction[$key]->id_active = $active[$row[$index['code']]];
            }
        }
       
        if (!empty($empty)) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'true', 'msg' => 'Existem ativos não listados no sistema, inclua para continuar... ' . implode(", ",$empty)));
            exit;
        }

        foreach ($transaction as $insert) {
            $insert->save();
        }

        header('Content-Type: application/json');
        echo json_encode(array('error' => 'false', 'msg' => 'Transações importadas com sucesso!'));
        exit;
    }

    function pickMovement ($movement) {
        if($movement == 'Compra'){
            return 'buy';
        } else if ($movement == 'Venda'){
            return 'sell';
        }
    }
}
