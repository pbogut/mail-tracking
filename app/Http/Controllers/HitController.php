<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HitLog;
use App\Models\MessageStatus;
use Carbon\Carbon;

class HitController extends Controller
{
    public function pixel(Request $request, $messageId)
    {
        $img = base64_decode(
            'R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='
        );

        $messageId = trim(base64_decode($messageId), '<>');
        $ipAddress = $request->server->get('REMOTE_ADDR');
        $userAgent = $request->server->get('HTTP_USER_AGENT');

        HitLog::create([
            'message_id' => $messageId,
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
        ]);

        $result = MessageStatus::updateOrCreate([
            'message_id' => $messageId,
            'opened' => true,
        ]);
        $now = Carbon::now()->__toString();
        $lastUpdate = $result->updated_at->__toString();
        if ($now != $lastUpdate) {
            $result->updated_at = Carbon::now();
            $result->save();
        }

        return response($img, 200, [
            'Content-Type' => 'image/gif',
            'Content-Length' => strlen($img),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => 0
        ]);
    }

    public function hitlog(Request $request)
    {
        $from = $request->from;
        $fromDate = Carbon::parse($from);

        $hits = HitLog::query()
            ->where('updated_at', '>', $fromDate)
            ->orderBy('updated_at', 'ASC')
            ->get();

        if ($request->unique) {
            $tmpHits = $hits;
            $hits = [];
            foreach ($tmpHits as $hit) {
                $hits[$hit->message_id] = $hit;
            }
            $hits = array_values($hits);
        }

        return $hits;
    }
}
