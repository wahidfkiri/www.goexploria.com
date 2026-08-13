<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\CompanyMeeting;
use App\Services\CompanyMeetingService;
use App\Services\MeetingDatesCheckup;
use Illuminate\Http\Request;
use Redirect;
use Carbon;
use DateTime;
use Knp\Snappy\Pdf;
use Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyMeetingRequest;
use App\Models\User;

class CompanyMeetingController extends Controller
{

    // Company TYPE
    // GET ROUTES
    public function add($company)
    {
        $company = Company::find($company);
        $users = User::select(['id', 'name'])->take(1000)->get();

        return view('back.company.meeting.add', compact('company', 'users'));
    }

    public function edit($company, $id)
    {
        $company = Company::find($company);
        $meeting = CompanyMeeting::find($id);
        $users = User::select(['id', 'name'])->take(1000)->get();

        return view('back.company.meeting.edit', compact('meeting', 'company', 'users'));
    }

    public function printPDF(Request $request, $company)
    {
        try {
            \Debugbar::disable();
            $start = $request->has('start') ? $request->get('start') : strtotime('-1 month');
            $end = $request->get('end', strtotime('+ 6 months'));
            $company = Company::findOrFail($company);
            $meetings = CompanyMeeting::where('company_id', $company->id)
                ->where('started_at', '>', $start)
                ->where('ended_at', '<', $end)->orderBy('started_at')
                ->orderBy('ended_at')->get();

            $html = (string)view('back.company.meeting.today', compact('meetings', 'company'));

            $filePath = CompanyMeetingService::printPDF($html, str_slug($company->name));
            return response()->file($filePath);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', $e->getMessage());
        }
    }

    public function details($company, $id)
    {
        $company = Company::find($company);
        $meeting = CompanyMeeting::find($id);
        return view('back.company.meeting.details', compact('meeting', 'company'));
    }

    public function printer($company, $start, $end)
    {
        \Debugbar::disable();

        $company = Company::find($company);
        $meetings = CompanyMeeting::where('started_at', '>', $start)->where('ended_at', '<', $end + 3600 * 24)->orderBy('started_at')->orderBy('ended_at')->get();

        return view('back.company.meeting.today', compact('meetings', 'company'));
    }

    public function delete($company, $id)
    {
        CompanyMeeting::find($id)->delete();
        return Redirect::route('company.meeting.search', [$company])->with('info', "Le rendez-vous a bien été supprimé");
    }

    public function index($company)
    {
        $company = Company::find($company);
        $events = CompanyMeetingService::parseMeeting($company->meetings, $company->id);

        $calendar = Calendar::addEvents($events)->setOptions(['firstDay' => 1, 'lang' => 'fr']);
        $calendar->setOptions([
            'timeZone' => config('app.timezone')
        ]);
        return view('back.company.meeting.search', compact('company', 'calendar'));
    }


    // POST ROUTES
    public function register(CompanyMeetingRequest $request, $company)
    {
        $rangeDate = explode(' => ', $request->date);

        $checker = new MeetingDatesCheckup(Carbon::createFromFormat('d/m/Y H:i', $rangeDate[0])->timestamp, Carbon::createFromFormat('d/m/Y H:i', $rangeDate[1])->timestamp);
        if (!$checker->isFree()) {
            return redirect()->back()->with('error', 'Un autre rendez-vous entre en conflit.')->withInput($request->all());
        }
        $meeting = new CompanyMeeting();
        $meeting->company_id = $company;
        $meetingService = new CompanyMeetingService($request, $meeting);

        $meetingService->save();

        return Redirect::route('company.meeting.search', [
            $company
        ])->with('success', "Le rendez-vous a été ajouté avec succès");;
    }

    public function update(CompanyMeetingRequest $request, $company, $id)
    {
        $meeting = CompanyMeeting::find($id);
        $meeting->company_id = $company;
        $meetingService = new CompanyMeetingService($request, $meeting);
        $meetingService->save();

        return Redirect::route('company.meeting.search', [
            $company
        ])->with('success', "Le rendez-vous a été modifié avec succès");
    }

}
