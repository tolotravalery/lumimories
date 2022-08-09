<?php
namespace App\Repositories;

use App\Models\Bougie;

interface IBougieRepository
{
    public function save(Bougie $bougie);

    public function getNombreBougiesGenerals();

    public function allumerBougiesGenerals();
}
