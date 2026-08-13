<?php
/**
 * Created by PhpStorm.
 * User: Tuhin
 * Date: 4/11/2019
 * Time: 9:39 AM
 */

namespace App\Services;


use App\Models\CompanyMeeting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Knp\Snappy\Pdf;
use App\Jobs\RemoveSystemGeneratedFile;
use Calendar;
use DateTime;

class CompanyMeetingService
{
    protected $request;
    protected $company;
    protected $meeting;

    public function __construct(Request $request, CompanyMeeting $meeting)
    {
        $this->request = $request;
        $this->meeting = $meeting;
    }

    /**
     * @return CompanyMeeting|bool
     */
    public function save()
    {
        $rangeDate = explode(' => ', $this->request->date);

        $this->meeting->name = $this->request->name;
        $this->meeting->started_at = Carbon::createFromFormat('d/m/Y H:i', $rangeDate[0])->timestamp;
        $this->meeting->ended_at = Carbon::createFromFormat('d/m/Y H:i', $rangeDate[1])->timestamp;
        $this->meeting->content = $this->request->get('content');
        $this->meeting->client = $this->request->client;
        $this->meeting->contact = $this->request->contact;
        if (auth()->check() && auth()->user()->isAdmin() && !empty($this->request->user_id)) {
            $this->meeting->user_id = $this->request->user_id;
        }
        $this->meeting->save();
        return $this->meeting;
    }

    /**
     * @param $meetings
     * @param $html
     * @param string $name
     * @return string
     */
    public static function printPDF($html, $name = 'printer')
    {
        $snappy = new Pdf('/usr/local/bin/wkhtmltopdf-amd64');
        $snappy->setOption('disable-javascript', true);

        $fileName = "downloads/" . str_slug($name) . '.pdf';
        if (!file_exists(public_path('downloads'))) {
            mkdir(public_path('downloads'));
        }
        $filePath = public_path($fileName);
        if (file_exists($fileName)) {
            unlink($filePath);
        }
        $job = new RemoveSystemGeneratedFile(public_path('downloads'));
        dispatch($job->delay(60 * 3));
        $snappy->generateFromHtml($html, $fileName);
        return $filePath;
    }

    /**
     * @param $meetings
     * @param bool $companyId
     * @return array
     */
    public static function parseMeeting($meetings, $companyId = false)
    {
        $events = [];
        foreach ($meetings as $meeting) {
            $startDate = (new DateTime("@$meeting->started_at"))->setTimezone(new \DateTimeZone(config('app.timezone')));
            $endDate = (new DateTime("@$meeting->ended_at"))->setTimezone(new \DateTimeZone(config('app.timezone')));
            if (!empty($companyId)) {
                $url = route('company.meeting.details', [$companyId, $meeting->id]);
            } else {
                $url = route('users.meeting.details', $meeting->id);
            }
            $events[] = Calendar::event(
                $meeting->name, false, $startDate, $endDate, $meeting->id, ['url' => $url]
            );
        }
        return $events;
    }
}