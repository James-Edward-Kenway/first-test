<?php

namespace Paycom;

use App\PaymentLog;
use App\User;


/**
 * Class Order
 *
 * Example MySQL table might look like to the following:
 *
 * CREATE TABLE orders
 * (
 *     id          INT AUTO_INCREMENT PRIMARY KEY,
 *     product_ids VARCHAR(255)   NOT NULL,
 *     amount      DECIMAL(18, 2) NOT NULL,
 *     state       TINYINT(1)     NOT NULL,
 *     user_id     INT            NOT NULL,
 *     phone       VARCHAR(15)    NOT NULL
 * ) ENGINE = InnoDB;
 *
 */
class Order extends Database
{
    /** Order is available for sell, anyone can buy it. */
    const STATE_AVAILABLE = 0;

    /** Pay in progress, order must not be changed. */
    const STATE_WAITING_PAY = 1;

    /** Order completed and not available for sell. */
    const STATE_PAY_ACCEPTED = 2;

    /** Order is cancelled. */
    const STATE_CANCELLED = 3;

    public $request_id = 0;

    public $params;

    // todo: Adjust Order specific fields for your needs

    /**
     * Order ID
     */
    public $id;

    /**
     * IDs of the selected products/services
     */
    public $product_ids;

    /**
     * Total price of the selected products/services
     */
    public $amount;

    /**
     * State of the order
     */
    public $state;

    /**
     * ID of the customer created the order
     */
    public $user_id;

    /**
     * Phone number of the user
     */
    public $phone;

    public function __construct(int $request_id = null)
    {
        $this->request_id = $request_id;
    }

    /**
     * Validates amount and account values.
     * @param array $params amount and account parameters to validate.
     * @return bool true - if validation passes
     * @throws PaycomException - if validation fails
     */
    public function validate(array $params)
    {
        // todo: Validate amount, if failed throw error
        // for example, check amount is numeric
        if (!is_numeric($params['amount'])) {
            throw new PaycomException(
                $this->request_id,
                'Incorrect amount.',
                PaycomException::ERROR_INVALID_AMOUNT
            );
        }

        // todo: Validate account, if failed throw error
        // assume, we should have client_id
        if (!isset($params['account']['client_id']) || !$params['account']['client_id']) {
            throw new PaycomException(
                $this->request_id,
                PaycomException::message(
                    'Неверный код заказа.',
                    'Harid kodida xatolik.',
                    'Incorrect order code.'
                ),
                PaycomException::ERROR_INVALID_ACCOUNT,
                'client_id'
            );
        }

        // todo: Check is order available

        // assume, after find() $this will be populated with Order data
        $order = $this->find($params['account']+['amount'=> $params['amount']]);

        // Check, is order found by specified client_id
        if (!$order || !$order->id) {
            throw new PaycomException(
                $this->request_id,
                PaycomException::message(
                    'Неверный код заказа.',
                    'Harid kodida xatolik.',
                    'Incorrect order code.'
                ),
                PaycomException::ERROR_INVALID_ACCOUNT,
                'client_id'
            );
        }
        // validate amount
        // convert $this->amount to coins
        // $params['amount'] already in coins
        if ((100 * 1000) > (1 * $params['amount'])) {
            throw new PaycomException(
                $this->request_id,
                'Incorrect amount.',
                PaycomException::ERROR_INVALID_AMOUNT
            );
        }

        // for example, order state before payment should be 'waiting pay'
        
        // if ($this->state != self::STATE_WAITING_PAY) {
        //     throw new PaycomException(
        //         $this->request_id,
        //         'Order state is invalid.',
        //         PaycomException::ERROR_COULD_NOT_PERFORM
        //     );
        // }

        // keep params for further use
        $this->params = $params;

        return true;
    }

    /**
     * Find order by given parameters.
     * @param mixed $params parameters.
     * @return Order|Order[] found order or array of orders.
     */
     
    public function find($params)
    {
        // todo: Implement searching order(s) by given parameters, populate current instance with data

        // Example implementation to load order by id

        if (isset($params['client_id'])) {

            $sql        = "select * from users where id=:clientId";
            $sth        = self::db()->prepare($sql);
            $is_success = $sth->execute([':clientId' => $params['client_id']]);

            if ($is_success) {

                $row = $sth->fetch();

                if ($row) {

                    $this->id          = 1 * $row['id'];
                    $this->amount      = $params['amount'] / 100;
                    return $this;

                }

            }

        }

        return null;
    }

    /**
     * Change order's state to specified one.
     * @param int $state new state of the order
     * @return void
     */
    public function changeState($state)
    {
        // todo: Implement changing order state (reserve order after create transaction or free order after cancel)

        // Example implementation
        $this->state = 1 * $state;
        $this->save();

    }

    /**
     * Check, whether order can be cancelled or not.
     * @return bool true - order is cancellable, otherwise false.
     */
    public function allowCancel()
    {
        // todo: Implement order cancelling allowance check

        // Example implementation
        return false; // do not allow cancellation
    }

    /**
     * Saves this order.
     * @throws PaycomException
     */
    public function save()
    {
        $db = self::db();

        if (!$this->id) {

            // If new order, set its state to waiting
            $this->state = self::STATE_WAITING_PAY;

            // todo: Set customer ID
            // $this->user_id = 1 * SomeSessionManager::get('user_id');

            // $sql        = "insert into orders set product_ids = :pProdIds, amount = :pAmount, state = :pState, user_id = :pUserId, phone = :pPhone";
            // $sth        = $db->prepare($sql);
            // $is_success = $sth->execute([
            //     ':pProdIds' => json_encode($this->product_ids),
            //     ':pAmount'  => $this->amount,
            //     ':pState'   => $this->state,
            //     ':pUserId'  => $this->user_id,
            //     ':pPhone'   => $this->phone,
            // ]);

            // $this->id = \Auth::user()->id;
            $is_success = true;
        } else {


        }

        if($this->state==1*Order::STATE_PAY_ACCEPTED){

            $u = User::find($this->id);
            $u->balance += $this->amount;
            $u->save();
            $p = new PaymentLog();
            $p->user_id = $this->id;
            $p->type = 1;
            $p->summa = $this->amount;
            $p->save();

        }
        $is_success = true;

        if (!$is_success) {
            throw new PaycomException($this->request_id, 'Could not save order.', PaycomException::ERROR_INTERNAL_SYSTEM);
        }
    }
}