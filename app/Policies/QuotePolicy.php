<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;

class QuotePolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true; // Tout le monde peut voir les citations
    }

    public function view(User $user, Quote $quote): bool
    {
        return true; // Tout le monde peut voir une citation
    }

    public function create(User $user): bool
    {
        return true; // Tout utilisateur authentifié peut créer
    }

    public function update(User $user, Quote $quote): bool
    {
        return $user->id === $quote->user_id;
    }

    public function delete(User $user, Quote $quote): bool
    {
        return $user->id === $quote->user_id;
    }
}
