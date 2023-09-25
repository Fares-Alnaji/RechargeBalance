<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResourceCollection;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Transaction;
use Doctrine\Inflector\Rules\Transformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransformationController extends Controller
{
    //
    public function transformation()
    {
        $merchants = Merchant::all();
        return response()->view('cms.transformation', ['merchants' => $merchants]);
    }

    public function transfer(Request $request)
    {
        $user = auth()->user();
        $merchant = Merchant::find($request->merchant_id);

        $amount = $request->amount;
        $fixedDeduction = 1.5;
        $inputDeduction = $request->deduction;

        $totalDeduction = $fixedDeduction + $inputDeduction;
        if ($user->active == 1) {
            if ($user->balance >= $amount) {

                $user->balance -= $amount;
                $isSavedAdmin = $user->save();

                $merchant->balance += $amount;
                $isSavedMerchant = $merchant->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'merchant_id' => $merchant->id,
                    'amount' => $amount,
                    'deduction' => $inputDeduction,
                    'merchant_balance_before' => $merchant->balance - $amount,
                    'merchant_balance_after' => $merchant->balance,
                ]);

                if ($isSavedAdmin && $isSavedMerchant) {
                    return response()->json(
                        [
                            'message' => "تمت عملية التحويل بنجاح",
                            'icon' => 'success',
                        ],
                        Response::HTTP_OK
                    );
                } else {
                    return response()->json(['message' => 'حصل خطأ، حاول مرة أخرى', 'icon' => 'error'], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json(['message' => ' رصيد غير كافي', 'icon' => 'error'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => ' الإدمن غير نشط', 'icon' => 'error'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        $Merchants = Merchant::all();
        $admin = Auth::user();
        $Transactions = Transaction::where('user_id', $admin->id)->paginate(10);

        if (auth('admin-api')->check()) {
            $Transactions = auth('admin-api')->user()->transactions()->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => new TransactionResourceCollection($Transactions)
            ]);
        } else {
            return response()->view('cms.index', ['Transactions' => $Transactions, 'Merchants' => $Merchants, 'admin' => $admin]);
        }

    }
}
