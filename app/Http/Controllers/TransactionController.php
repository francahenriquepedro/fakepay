<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTransactionRequest;
use App\Traits\ApiResponser;
use App\Http\Services\TransactionService;

class TransactionController extends Controller
{
    use ApiResponser;

    /**
     * Request method controller to receive a new transaction request on api
     *
     * @param NewTransactionRequest $request
     * @return void
     */
    public function new(NewTransactionRequest $request)
    {
        try{
            //Turn array into named vars
            extract($request->validated());

            //Create the transaction
            $transaction = TransactionService::create($payer, $payee, $value);

            return $this->success($transaction);

        } catch(\Exception $e) {
            return $this->error($e->getMessage(), 401);
        }
    }
}
