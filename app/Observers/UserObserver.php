<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $defaultCategories = [
            'Pengeluaran' => ['Makan', 'Transportasi', 'Belanja', 'Hiburan', 'Kesehatan'],
            'Pemasukan' => ['Bonus', 'Hadiah', 'Penjualan'],
        ];

        foreach ($defaultCategories as $type => $names) {
            foreach ($names as $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'type' => $type,
                ]);
            }
        }

        // Fallback
        Category::create([
            'user_id' => $user->id,
            'name' => 'Belum dikategorikan',
            'type' => 'Pengeluaran',
        ]);

        Category::create([
            'user_id' => $user->id,
            'name' => 'Belum dikategorikan',
            'type' => 'Pemasukan',
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
