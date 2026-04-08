<?php

namespace App\Console\Commands;

use App\Events\TicketExpirationChecker;
use App\Mail\ExpirationEmail;
use App\Mail\ExpiredEmail;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckDailyTicketExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-ticket-exp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Ticket Expiration Daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       self::setEmailSent(5);
       self::setEmailSent(2);
       self::setEmailSent(0);
        // event(new TicketExpirationChecker(1, "Tickets have expired"));

        $this->info("Checked");
    }
    public function initiate(){

    }
    public function setEmailSent(int $days  )
    {

        $data = Tickets::with("user")
                    ->whereDate('expiration_date', '=', now()->addDays($days)->toDateString());

        if($data->where("hasNotif",false)->count() === 0) return;
        if($data->where("hasExpired",false)->count() === 0) return;

        $user = User::has("tickets")->with(['tickets'])->get();

        foreach ($user as $key => $usr) {
            $email = $usr->email;
            if($days === 0) Mail::to($email,$usr->name)->send(new ExpiredEmail($usr->tickets,$days));
            else Mail::to($email,$usr->name)->send(new ExpirationEmail($usr->tickets,$days));
        }
        $data->each( function($result){
            if($result->user){
                $result->update([
                    'hasNotif' => 1
                ]);
            }
        });

    }

}
