<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function paymentCart(Request $request)
    {
         return $this->paymentService->paymentCart($request);

    }

    public function createPaymentVNPAY(Request $request){
        return $this->paymentService->createPaymentVNPAY($request);
    }

    public function vnpayReturn(Request $request){
        return $this->paymentService->vnpayReturn($request);
    }

}
