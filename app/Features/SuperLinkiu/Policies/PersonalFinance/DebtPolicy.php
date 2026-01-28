<?php

namespace App\Features\SuperLinkiu\Policies\PersonalFinance;

use App\Models\User;
use App\Features\SuperLinkiu\Models\PersonalFinance\Debt;

class DebtPolicy
{
    public function view(User $user, Debt $debt): bool
    {
        return $user->id === $debt->user_id;
    }

    public function update(User $user, Debt $debt): bool
    {
        return $user->id === $debt->user_id;
    }

    public function delete(User $user, Debt $debt): bool
    {
        return $user->id === $debt->user_id;
    }
}
