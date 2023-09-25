<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'merchant_name' => $transaction->merchant->name,
                    'merchant_account_number' => $transaction->merchant->account_number,
                    'amount_before_discount' => $transaction->amount,
                    'amount_after_discount' => $transaction->amount - $transaction->deduction - 1.5,
                    'fixed_deduction' => 1.5,
                    'deduction_entered' => $transaction->deduction,
                    'merchant_balance_before' => $transaction->merchant_balance_before,
                    'merchant_balance_after' => $transaction->merchant_balance_after,
                    'admin_balance_before' => $transaction->admin->balance + $transaction->amount,
                    'admin_balance_after' => $transaction->admin->balance,
                    'process_code' => rand(0, 99999),
                    'transfer_date' => $transaction->created_at,
                ];
            }),
        ];
    }
}
