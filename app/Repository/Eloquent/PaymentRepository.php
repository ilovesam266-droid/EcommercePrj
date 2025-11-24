<?php

namespace App\Repository\Eloquent;

use App\Models\Payment;
use App\Repository\Constracts\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function getModel()
    {
        return Payment::class;
    }

    public function findByTransactionCode($code)
    {
        return $this->model->where('transaction_code', $code)->first();
    }

    public function firstOrCreate($conditions, $data)
    {
        return $this->model->firstOrCreate($conditions, $data);
    }
}
