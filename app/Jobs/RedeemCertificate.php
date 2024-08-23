<?php

namespace App\Jobs;

use App\Models\ShopUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RedeemCertificate implements ShouldQueue
{
    use Queueable;

    private ShopUser $user;

    /**
     * Create a new job instance.
     */
    public function __construct(ShopUser $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->user->redeemCertificate) {
            $this->user->balance += 200;
            $this->user->save();
            $this->user->redeemCertificate = 1;
            $this->user->save();
        }
    }
}
