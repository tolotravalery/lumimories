<?php


namespace App\Notifications;


use App\Models\Profil;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AnniversaireDeces extends Notification
{
    private $profil;
    private $image;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Profil $profil, $image)
    {
        $this->profil = $profil;
        $this->image =$image;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $jdNumber = gregoriantojd(Carbon::parse($this->profil->dateDeces)->format('m'), Carbon::parse($this->profil->dateDeces)->format('d'), Carbon::parse($this->profil->dateDeces)->format('Y'));
        $jewishDate = jdtojewish($jdNumber);
        list($jewishMonth, $jewishDay, $jewishYear) = explode('/', $jewishDate);
        $jewishMonthName = $this->getJewishMonthName($jewishMonth, $jewishYear);
        $date = "$jewishDay $jewishMonthName $jewishYear";
        $content = array(
            'url' => url('/detail/' . $this->profil->id),
            'image' => asset($this->image),
            'hebrewDate' => $this->profil->religion == "judaisme" ? "Date: ".$date : "Date: ". Carbon::parse($this->profil->dateDeces)->format('d-m-Y')
        );
        return (new MailMessage)
            ->from("contact@lumimories.com", "Lumimories")
            ->subject(__($this->profil->nomFirstProfil() . ' : ANNIVERSAIRE DE DÉCÈS'))
            ->markdown('email.email-anniversaire-deces',$content);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function isJewishLeapYear($year)
    {
        if ($year % 19 == 0 || $year % 19 == 3 || $year % 19 == 6 ||
            $year % 19 == 8 || $year % 19 == 11 || $year % 19 == 14 ||
            $year % 19 == 17)
            return true;
        else
            return false;
    }

    public function getJewishMonthName($jewishMonth, $jewishYear) {
        $jewishMonthNamesLeap = array("Tishri", "Heshvan", "Kislev", "Tevet",
            "Shevat", "Adar I", "Adar II", "Nisan",
            "Iyar", "Sivan", "Tammuz", "Av", "Elul");
        $jewishMonthNamesNonLeap = array("Tishri", "Heshvan", "Kislev", "Tevet",
            "Shevat", "", "Adar", "Nisan",
            "Iyar", "Sivan", "Tammuz", "Av", "Elul");
        if ($this->isJewishLeapYear($jewishYear))
            return $jewishMonthNamesLeap[$jewishMonth-1];
        else
            return $jewishMonthNamesNonLeap[$jewishMonth-1];
    }
}