<?php

namespace App\Http\Controllers\Backend;

use App\Complain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Support\Arr;

class SettingController extends Controller
{
    public function index()
    {
        $complain = Complain::find(528);
        $recipients = [];
        foreach ($complain->message_recipients as $message_recipient) {
            $recipients[] = explode(",", $message_recipient->numbers);
        }
        return dd(implode(",",collect(Arr::flatten($recipients))->unique()->all()));
        $setting = Setting::firstOrFail();
        return view("architect.settings.index", compact('setting'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_method', '_token') as $index => $value)
        {
            Setting::where("key", "=", $index)->update([
                "value" => $value
            ]);
        }

        return redirect()->route('settings.index');
    }
}
