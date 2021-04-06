<?php

namespace App\Http\Services;

use App\Models\CommonUser;
use App\Models\User;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    /**
     * Create a Transaction with capture attempt
     *
     * @param integer $payer
     * @param integer $payee
     * @param float $value
     * @return Transaction
     */
    public static function create(int $payer, int $payee, float $value): Transaction
    {
        //Check if isn't the same user
        if ($payer == $payee) {
            throw new Exception("It is not possible to carry out a transaction for the same person");
        }

        //The payer must be a CommonUser
        $Payer = CommonUser::find($payer);
        if ( ! $Payer ) {
            throw new Exception("Invalid payer");
        }

        //The Payee can be any type of User
        $Payee = User::find($payee);
        if ( ! $Payee ) {
            throw new Exception("Invalid payee");
        }

        //Check if wallet have founds
        if ($Payer->wallet < $value) {
            throw new Exception("Insufficient funds");
        }

        //Save transaction without capture on database
        $transaction = Transaction::create([
            'payer'  => $payer,
            'payee'  => $payee,
            'value'  => $value,
            'status' => 'waiting'
        ]);

        //Capture the transaction
        $transaction = self::capture($transaction);

        return $transaction;
    }

    /**
     * Capture a Transaction
     *
     * @param Transaction $transaction
     * @return Transaction
     */
    public static function capture(Transaction $transaction): Transaction
    {
        try{
            //Returns from mocky to simulate transaction capture
            $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            $data = $response->json();

            //Mocky based conditional to check if transaction is valid
            if ($data['message'] == "Autorizado") {
                //Do the wallet transaction
                $payer = CommonUser::find($transaction->payer);
                $payee = User::find($transaction->payee);

                $payer->wallet -= $transaction->value;
                $payee->wallet += $transaction->value;

                $payer->save();
                $payee->save();

                //Update the transaction status
                $transaction->status = 'approved';
                $transaction->save();
            }

        } catch(Exception $e) {
            //Add request error o logfile
            error_log("Capture transaction HTTP error: ". $e->getMessage());
        }

        return $transaction;
    }

    /**
     * Rollback Transaction
     *
     * @param Transaction $transaction
     * @return void
     */
    public static function rollback(Transaction $transaction): void
    {
        //Do the wallet transaction
        $payer = CommonUser::find($transaction->payer);
        $payee = User::find($transaction->payee);

        $payer->wallet += $transaction->value;
        $payee->wallet -= $transaction->value;

        $payer->save();
        $payee->save();

        //Update the transaction status
        $transaction->status = 'canceled';
        $transaction->save();
    }
}
