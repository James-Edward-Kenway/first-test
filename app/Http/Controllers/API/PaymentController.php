<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public $payme;
    public function paymeInit(){
        require_once(('Paycom/Paycom/Format.php'));
        require_once(('Paycom/Paycom/Database.php'));
        require_once(('Paycom/Paycom/Request.php'));
        require_once(('Paycom/Paycom/Order.php'));
        require_once(('Paycom/Paycom/Response.php'));
        require_once(('Paycom/Paycom/Transaction.php'));
        require_once(('Paycom/Paycom/Merchant.php'));
        require_once(('Paycom/Paycom/PaycomException.php'));
        require_once(('Paycom/Paycom/Application.php'));
        $vari = ('Paycom/paycom.config.php');
        $paycomConfig = require_once $vari;

        $this->payme = new \Paycom\Application($paycomConfig);
        $this->payme->run();
    }
}