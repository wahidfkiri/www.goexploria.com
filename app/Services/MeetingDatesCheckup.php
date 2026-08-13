<?php
/**
 * Created by PhpStorm.
 * User: Tuhin
 * Date: 4/10/2019
 * Time: 5:56 PM
 */

namespace App\Services;


use App\Models\CompanyMeeting;
use App\Models\User;

class MeetingDatesCheckup
{
    /**
     * @var User
     */
    protected $user;
    private $start;
    private $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->user = auth()->user();
    }

    /**
     * @param bool $id Current ID
     * @return bool
     */
    public function isFree($id = false)
    {
        $start = $this->start;
        $end = $this->end;
        $model = CompanyMeeting::where('user_id', $this->user->id);
        if (!empty($id)) {
            $model = $model->where('id','<>', $id);
        }
        $meeting = $model->where(function ($q) use ($start, $end) {
            $q->orWhereBetween('started_at', [$start, $end])
                ->orWhereBetween('ended_at', [$start, $end])
                ->orWhere(function ($sq) use ($start, $end) {
                    $sq->where('started_at', '<', $start)->where('ended_at', '>', $end);
                })->orWhere(function ($sq) use ($start, $end) {
                    $sq->where('started_at', '>', $start)->where('ended_at', '<', $end);
                });
        })->get();

        $filtered = [];

        foreach($meeting as $verified) {
            if (($verified->ended_at !== $start) && ($verified->started_at !== $end)) {
                $filtered[] = $verified;
            }
        }

        return count_of($filtered) > 0 ? false : true;
    }
}