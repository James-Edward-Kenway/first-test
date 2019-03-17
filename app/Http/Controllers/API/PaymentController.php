<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public $payme;
    public function PaymeInit(){
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Format.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Database.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Request.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Order.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Response.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Transaction.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Merchant.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/PaycomException.php'));
        include_once(base_path('/app/Http/Controller/API/Paycom/Paycom/Application.php'));
        $vari = base_path('/app/Http/Controller/API/Paycom/paycom.config.php');
        $paycomConfig = require_once CONFIG_FILE;
        
        $this->payme = new \Paycom\Application($paycomConfig, $vari);
        $this->payme->run();
        dd($this->payme);
    }
}