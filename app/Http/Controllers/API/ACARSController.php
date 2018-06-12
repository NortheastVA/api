<?php
namespace App\Http\Controllers\API;

use App\ACARSMessageQueue;
use App\FlightLog;
use App\Helpers\ACARSHelper;
use Illuminate\Http\Request;

class ACARSController extends APIController
{
    /*
     * Check for and send pending ACARS messages.
     */
    public function get(Request $request) {
        $return = [];

        $logs = \Auth::user()->acars_queue;
        foreach ($logs as $log) {
            $return[] = $log;
        }

        return response()->ok(['data' => $return]);
    }

    /*
     * Receive and process ACARS message.
     */
    public function post(Request $request) {
        if (!$request->input("payload")) {
            return response()->malformed();
        }

        $payload = json_decode($request->input("payload"));
        if (!$payload) {
            // Invalid JSON
            return response()->malformed();
        }

        if (!is_array($payload)) {
            $payload[0] = $payload;
        }

        // Run quick check on cmds, make sure they are all defined otherwise reject the request
        foreach ($payload as $key => $value) {
            if (!isset($value->cmd)) return response()->malformed();
            if (!isset(ACARSHelper::$cmd[$value->cmd])) return response()->notfound(['details' => $value->cmd]);
        }

        $return = [];

        // Run commands
        foreach ($payload as $key => $value) {
            \Log::info(json_encode($value->data));
            $r = call_user_func(ACARSHelper::$cmd[$value->cmd], $value->data);
            array_push($return, $r);
        }

        return response()->ok(['data' => $return]);
    }
}
