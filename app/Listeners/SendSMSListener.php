<?php

namespace App\Listeners;

use App\Complain;
use App\Events\SendSMSEvent;
use App\Setting;
use GuzzleHttp\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;

class SendSMSListener
{
    private $statuses = ['Open', 'Closed', 'Pending'];
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendSMSEvent  $event
     * @return void
     */
    public function handle(SendSMSEvent $event)
    {
        try {
            $this->sendMessage($event->complain);
        } catch (\Exception $e) {

        }
    }

    public function sendMessage(Complain $complain)
    {
        $template = "Outlet: " . $complain->outlet->name . "\nIssue(s): " . implode(",", $complain->issues()->pluck('name')->toArray()) . "\nInformed to: " . $complain->maintenance_user->name . "\nInformed By: " . $complain->informed_by . "\nTicket#: " . $complain->getComplainNumber() . "\nStatus: " . $complain->ticket_status->name . "\nDetails: " . $complain->desc . ($complain->remarks ? "\nRemarks: $complain->remarks" : "");
        $url = Setting::where("key", "=", "url")->first()->value;
        $username = Setting::where("key", "=", "username")->first()->value;
        $password = Setting::where("key", "=", "password")->first()->value;
        if(in_array($complain->ticket_status->name, $this->statuses))
        {
            if($complain->message_recipients()->exists()) {
                $recipients = [];
                foreach ($complain->message_recipients as $message_recipient) {
                    $recipients[] = explode(",", $message_recipient->numbers);
                }
                $recipients = collect(Arr::flatten($recipients))->unique()->all();
                $client = new Client();
                $response = $client->get($url, ['query' => [
                    'username' => $username,
                    'password' => $password,
                    'receiver' => implode(",", $recipients),
                    'msgdata' => $template
                ]]);
                dump($response->getBody());
                $complain->message_responses()->create([
                    'receiver' => implode(",", $recipients),
                    'response' => $response->getReasonPhrase(),
                    'code' => $response->getStatusCode(),
                    'status' => $complain->ticket_status->name,
                    'message' => $response->getBody()
                ]);
            }
        }
    }
}
