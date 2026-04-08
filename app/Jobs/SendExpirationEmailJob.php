<?php

namespace App\Jobs;

use App\Mail\ExpirationEmail;
use App\Mail\ExpiredEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendExpirationEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $userId,
        private bool $isExpiredSoon, // 'expiring' or 'expired'
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::with('tickets')->find($this->userId);
            if($this->isExpiredSoon){
                Mail::to($user->email,$user->name)->send(new ExpirationEmail($user->tickets(),5));
            }else{
                Mail::to($user->email,$user->name)->send(new ExpiredEmail($user->tickets(),0));
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
