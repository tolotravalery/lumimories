<?php

namespace App\Console\Commands;

use App\Models\Profil;
use App\Models\User;
use App\Notifications\AnniversaireDeces;
use App\Services\IGeneralService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AnniversaireDecesCron extends Command
{
    private $generalService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anniversaire-deces:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anniversaire Decees description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IGeneralService $generalService)
    {
        parent::__construct();
        $this->generalService = $generalService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $profils = Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->whereMonth('dateDeces', Carbon::today()->month)->whereDay('dateDeces', Carbon::today()->day)->get();
        //$profils = Profil::where('validerParAdmin', '=', true)->whereIn('id',[28])->get();
        if(count($profils) > 0) {
            foreach ($profils as $profil){
                $nbre = Carbon::today()->diff(Carbon::parse($profil->dateDeces))->format('%y');
                //$image = $this->generalService->mergeImageWithText(explode("|", $profil->photometa)[0] ? explode("|", $profil->photometa)[0] : "public/photo-profiles/default.jpg", $nbre." ANS DEJA");
                $image = $this->generalService->imageAnniversaire(explode("|",$profil->photoProfil)[0] ?  explode("|",$profil->photoProfil)[0] : "public/photo-profiles/default.jpg",'public/front/img/bougie-removebg-preview.png', $nbre." ANS DEJA");
                $profil->photoanniveraire = $image;
                $profil->save();
                $users = $profil->usersSuivre;
                $users->push($profil->user);
                Notification::send($users, new AnniversaireDeces($profil,$image));
            }
        }
    }
}
