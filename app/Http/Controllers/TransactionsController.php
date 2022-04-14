<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Actives;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $transactions = transactions::where('id_user', auth()->user()->id)->get();
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
                    $data = str_replace(',','.', str_replace('R$ ','', $data));
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
        $transaction = transactions::where('uuid', $uuid)->where('id_user', auth()->user()->id)->firstOrFail();
        
        $formData = $request->all();

        $transaction = new Transactions;
        $transaction->uuid = Str::uuid();
        $transaction->id_user = auth()->user()->id;

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
}
