<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;

class PortfolioPolicy
{
    /**
     * Determine if the user can create a portfolio.
     * Hanya Kreator (individual) yang bisa upload karya
     * Recruiter/Company TIDAK bisa upload portfolio
     */
    public function create(User $user): bool
    {
        // Hanya kreator (individual) yang bisa membuat portfolio
        return $user->user_type === 'individual';
    }

    /**
     * Determine if the user can view portfolios.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view a portfolio.
     */
    public function view(User $user, Portfolio $portfolio): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the portfolio (edit profil portofolio).
     * Kreator bisa mengedit profil portfolio miliknya sendiri
     */
    public function update(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine if the user can delete the portfolio.
     * Hanya pemilik portfolio yang bisa delete
     */
    public function delete(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }
}
