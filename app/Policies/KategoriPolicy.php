<?php

namespace App\Policies;

use App\Models\Kategori;
use App\Models\Pengguna;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Pengguna $pengguna)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Pengguna $pengguna, Kategori $kategori)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Pengguna $pengguna)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Pengguna $pengguna, Kategori $kategori)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Pengguna $pengguna, Kategori $kategori)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Pengguna $pengguna, Kategori $kategori)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Pengguna $pengguna, Kategori $kategori)
    {
        //
    }
}
