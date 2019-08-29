<?php

namespace App\Observers;

use App\Complain;
use App\Setting;
use GuzzleHttp\Client;

class ComplainObserver
{
    private $statuses = ['Open', 'Closed'];
    /**
     * Handle the complain "created" event.
     *
     * @param  \App\Complain  $complain
     * @return void
     */
    public function created(Complain $complain)
    {
        $this->sendMessage($complain);
    }

    /**
     * Handle the complain "updated" event.
     *
     * @param  \App\Complain  $complain
     * @return void
     */
    public function updated(Complain $complain)
    {
        $this->sendMessage($complain);
    }

    /**
     * Handle the complain "deleted" event.
     *
     * @param  \App\Complain  $complain
     * @return void
     */
    public function deleted(Complain $complain)
    {
        //
    }

    /**
     * Handle the complain "restored" event.
     *
     * @param  \App\Complain  $complain
     * @return void
     */
    public function restored(Complain $complain)
    {
        //
    }

    /**
     * Handle the complain "force deleted" event.
     *
     * @param  \App\Complain  $complain
     * @return void
     */
    public function forceDeleted(Complain $complain)
    {
        //
    }

    public function sendMessage(Complain $complain)
    {
        $template = "Outlet: " . $complain->outlet->name . "\nIssue(s): " . implode(",", $complain->issues()->pluck('name')->toArray()) . "\nInformed to: " . $complain->maintenance_user->name . "\nInformed By: " . $complain->informed_by . "\nTicket#: " . $complain->getComplainNumber() . "\nStatus: " . $complain->ticket_status->name . "\nDetails: " . $complain->desc;
        $url = Setting::where("key", "=", "url")->first()->value;
        $username = Setting::where("key", "=", "username")->first()->value;
        $password = Setting::where("key", "=", "password")->first()->value;
        if(in_array($complain->ticket_status->name, $this->statuses))
        {
            $client = new Client();
            $response = $client->get($url, ['query' => [
                'username' => $username,
                'password' => $password,
                'receiver' => $complain->customer->number,
                'msgdata' => $template
            ]]);
            $complain->message_responses()->create([
                'receiver' => $complain->customer->number,
                'response' => $response->getReasonPhrase(),
                'code' => $response->getStatusCode(),
                'status' => $complain->ticket_status->name,
                'message' => $response->getBody()
            ]);

            if($complain->message_recipients()->exists()) {
                foreach ($complain->message_recipients as $message_recipient) {
                    $client = new Client();
                    $response = $client->get($url, ['query' => [
                        'username' => $username,
                        'password' => $password,
                        'receiver' => $message_recipient->numbers,
                        'msgdata' => $template
                    ]]);
                    $complain->message_responses()->create([
                        'receiver' => $message_recipient->numbers,
                        'response' => $response->getReasonPhrase(),
                        'code' => $response->getStatusCode(),
                        'status' => $complain->ticket_status->name,
                        'message' => $response->getBody()
                    ]);
                }
            }
        }
    }
}
