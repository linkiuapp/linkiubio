<?php

namespace App\Features\SuperLinkiu\Policies\PersonalFinance;

use App\Models\User;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;

class AccountPolicy
{
    public function view(User $user, Account $account): bool
    {
        return $user->id === $account->user_id;
    }

    public function update(User $user, Account $account): bool
    {
        return $user->id === $account->user_id;
    }

    public function delete(User $user, Account $account): bool
    {
        return $user->id === $account->user_id;
    }
}
