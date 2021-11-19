<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    // Número de items por página
    private const PAGE_OFFSET = 15;

    public function getAll(?array $filters = []): array
    {
        $payments = Payment::paginate(self::PAGE_OFFSET);

        if (!empty($filters)) {
            $payments = Payment::where($filters)
                ->paginate(self::PAGE_OFFSET);
        }

        return $payments
            ->toArray();
    }

    public function get(int $id): Payment
    {
        return Payment::findOrFail($id);
    }

    public function create(Payment $payment): Payment
    {
        $payment->save();
        return $payment;
    }

    public function update(Payment $payment): Payment
    {
        $payment->save();
        return $payment;
    }

    public function delete(int $id): void
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
    }
}
