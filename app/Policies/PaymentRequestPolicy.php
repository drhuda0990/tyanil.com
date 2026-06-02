<?php

namespace App\Policies;

use App\PaymentRequest;
use App\User;
use Illuminate\Auth\Access\Response;

class PaymentRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PaymentRequest $paymentRequest): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PaymentRequest $paymentRequest): bool
    {
        return true;
    }

    public function delete(User $user, PaymentRequest $paymentRequest): bool
    {
        return true;
    }

    public function restore(User $user, PaymentRequest $paymentRequest): bool
    {
        return true;
    }

    public function forceDelete(User $user, PaymentRequest $paymentRequest): bool
    {
        return true;
    }
}
