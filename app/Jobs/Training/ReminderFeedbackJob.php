<?php

namespace App\Jobs\Training;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MailTraining\RemindFeedback;
use Throwable;

class ReminderFeedbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $detail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to(['address' => $this->detail->User->user_email])
        ->cc([
            'system.imawiproite@wipro-unza.co.id',
            // 'nurul.amaliyah@wipro-unza.co.id',
            // 'ardhini.retno@wipro-unza.co.id'
        ])
        ->send(new RemindFeedback($this->detail));
    }

    public function failed(Throwable $exception)
    {
        return $exception->getMessage();
        // etc...
    }
}
