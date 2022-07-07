<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use Barryvdh\DomPDF\Facade as PDF;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request)
    {
        echo "<pre>";
        $user = auth()->user();
        $transactions = transactions::orderBy('transactions.date', 'asc')->where('id_user', auth()->user()->id)->join('actives', 'actives.id', '=', 'transactions.id_active')->get();
        $yearSelected = $request->year;
        $registers = array();
        foreach ($transactions as $key => $row) {
            $registers[$this->getYear($row->date)] = array();
        }

        foreach ($registers as $year => $yearTransactions) {
            foreach ($transactions as $transaction) {
                if ($this->getYear($transaction->date) == $year) {
                    $registers[$year][] = $transaction;
                }
            }
        }

        $compiled = array();

        foreach ($registers as $year => $transactions) {
            foreach ($transactions as $transaction) {
                if (empty($compiled[$year][$transaction->broker][$transaction->code][$transaction->movement]['quantity'])) {
                    $compiled[$year][$transaction->broker][$transaction->code][$transaction->movement]['quantity'] = $transaction->amount;
                    $compiled[$year][$transaction->broker][$transaction->code][$transaction->movement]['total'] = $transaction->total;
                } else {
                    $compiled[$year][$transaction->broker][$transaction->code][$transaction->movement]['quantity'] += $transaction->amount;
                    $compiled[$year][$transaction->broker][$transaction->code][$transaction->movement]['total'] += $transaction->total;
                }
            }
        }
        $average = array();
        foreach ($compiled as $year => $row) {
            foreach ($row as $broker => $actives) {
                foreach ($actives as $active => $rows) {
                    if (!empty($rows['buy'])) {
                        $average[$year][$broker][$active]['buy']['average'] = $rows['buy']['total'] / $rows['buy']['quantity'];
                        $average[$year][$broker][$active]['buy']['quantity'] = $rows['buy']['quantity'];
                    }
                    if (!empty($rows['sell'])) {
                        $average[$year][$broker][$active]['sell']['average'] = $rows['sell']['total'] / $rows['sell']['quantity'];
                        $average[$year][$broker][$active]['sell']['quantity'] = $rows['sell']['quantity'];
                    }
                }
            }
        }

        var_dump($average[$yearSelected]);exit;

        $transactionYears = array();

        foreach($transactions as $key => $row) {
            $transactionYears[$this->getYear($row->date)][] = $row;
        }

        $position = array();
        foreach($transactionYears as $year => $movements) {
            foreach($movements as $movement) {
                if($movement->movement == "buy") {
                    if(empty($position[$year][$movement->code]['buy']['amount']) && empty($position[$year][$movement->code]['buy']['price'])) {
                        $position[$year][$movement->code]['buy']['price'] = $movement->price;
                        $position[$year][$movement->code]['buy']['amount'] = $movement->amount;
                    } else{
                        $position[$year][$movement->code]['buy']['amount'] += $movement->amount;
                        $position[$year][$movement->code]['buy']['price'] += $movement->price;
                    }
                }
            }
        }
        echo "<pre>";
        var_dump($transactions);exit;
        // var_dump($this->getYear($transactions[0]->date));exit;

        $year = $request->year;
        $dataItens = array();

        foreach($transactions as $key => $row) {
            $dataItens[$key]['code'] = $row->code;
            $dataItens[$key]['cnpj'] = $row->cnpj;
            $dataItens[$key]['name'] = $row->name;
            $dataItens[$key]['broker'] = $row->broker;
            $dataItens[$key]['amount'] = $row->amount;
            $dataItens[$key]['startValue'] = '313,90';
            $dataItens[$key]['endValue'] = '481,92';
        }

        $pdf = PDF::loadView('Report-assets', compact('dataItens','user'));
        return $pdf->stream('whateveryourviewname.pdf');
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Pick Year of date
     * 
     * @param  timestamp  $date
    **/
    public function getYear($date) {
        return date("Y", strtotime($date));
    }
}
