<?php

namespace App\Features\SuperLinkiu\Policies\PersonalFinance;

use App\Models\User;
use App\Features\SuperLinkiu\Models\PersonalFinance\Installment;

class InstallmentPolicy
{
    public function view(User $user, Installment $installment): bool
    {
        return $user->id === $installment->debt->user_id;
    }

    public function update(User $user, Installment $installment): bool
    {
        return $user->id === $installment->debt->user_id;
    }
}
