<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\RemoveSystemGeneratedFile;
use App\Models\Company;
use App\Models\CompanyMeeting;
use App\Services\MeetingDatesCheckup;
use Illuminate\Http\Request;
use Redirect;
use Carbon\Carbon;
use DateTime;
use Knp\Snappy\Pdf;
use Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyMeetingRequest;
use App\Services\CompanyMeetingService;
use App\Models\User;

class UserMeetingController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->get('user_id');
        if (auth()->user()->isAdmin() && !empty($user_id)) {
            $events = CompanyMeetingService::parseMeeting(CompanyMeeting::where('user_id', $user_id)->get());
        } else {
            $user_id = auth()->id();
            $events = CompanyMeetingService::parseMeeting(auth()->user()->meetings);
        }

        $calendar = Calendar::addEvents($events)->setOptions(['firstDay' => 1, 'lang' => 'fr']);
        $calendar->setOptions([
            'timeZone' => config('app.timezone')
        ]);
        $users = User::select(['id', 'name'])->take(1000)->get();

        return view('back.users.meeting.search', compact('calendar', 'user_id', 'users'));
    }


    // Company TYPE
    // GET ROUTES
    public function add(Request $request)
    {
        $companies = Company::select(['id', 'name'])->get();
        $user_id = $request->get('user_id');
        if (auth()->user()->isAdmin()) {
            // Sans user_id valide en query string, User::find() renvoyait null
            // et la vue échouait sur $user->name (fatal depuis PHP 8).
            // On retombe alors sur l'utilisateur connecté, comme dans la
            // branche non-administrateur ci-dessous.
            $user = User::find($user_id) ?: auth()->user();
        } else {
            $user = auth()->user();
        }

        $users = User::select(['id', 'name'])->take(1000)->get();

        return view('back.users.meeting.add', compact('companies', 'users', 'user'));
    }

    public function edit($id)
    {

        $users = User::select(['id', 'name'])->take(1000)->get();
        if (auth()->user()->isAdmin()) {
            $meeting = CompanyMeeting::where('id', $id)->firstOrFail();
        } else {
            $meeting = CompanyMeeting::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        }
        $user = $meeting->user;
        return view('back.users.meeting.edit', compact('meeting', 'users', 'user'));
    }

    public function printPDF(Request $request)
    {
        try {
            \Debugbar::disable();
            $start = $request->has('start') ? $request->get('start') : strtotime('-1 month');

            $end = $request->get('end', strtotime('+ 6 months'));
            $user_id = auth()->user()->isAdmin() ? $request->get('user_id', auth()->id()) : auth()->id();
            $meetings = CompanyMeeting::where('user_id', $user_id)
                ->where('started_at', '>', $start)
                ->where('ended_at', '<', $end)->orderBy('started_at')
                ->orderBy('ended_at')->get();
            $user = User::find($user_id);
            $html = (string)view('back.users.meeting.today', compact('meetings', 'user'));

            $filePath = CompanyMeetingService::printPDF($html, str_slug(auth()->user()->name));
            return response()->file($filePath);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', $e->getMessage());
        }
    }

    public function details($id)
    {
        if (auth()->user()->isAdmin()) {
            $meeting = CompanyMeeting::where('id', $id)->firstOrFail();
        } else {
            $meeting = CompanyMeeting::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        }

        return view('back.users.meeting.details', compact('meeting'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (auth()->user()->isAdmin()) {
            $meeting = CompanyMeeting::where('id', $id)->firstOrFail();
        } else {
            $meeting = CompanyMeeting::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        }
        $user_id = $meeting->user_id;
        $meeting->delete();
        return Redirect::route('users.meeting.search', ['user_id' => $user_id])->with('info', "Le rendez-vous a bien été supprimé");
    }

    // POST ROUTES
    public function register(CompanyMeetingRequest $request)
    {
        $rangeDate = explode(' => ', $request->date);
        $checker = new MeetingDatesCheckup(Carbon::createFromFormat('d/m/Y H:i', $rangeDate[0])->timestamp, Carbon::createFromFormat('d/m/Y H:i', $rangeDate[1])->timestamp);
        if (!$checker->isFree()) {
            return redirect()->back()->with('error', 'Un autre rendez-vous entre en conflit.')->withInput($request->all());
        }
        $meeting = new CompanyMeeting();
        $meeting->company_id = $request->company_id;
        $meetingService = new CompanyMeetingService($request, $meeting);
        $meeting = $meetingService->save();

        return Redirect::route('users.meeting.search', ['user_id' => $meeting->user_id])
            ->with('success', "Le rendez-vous a été ajouté avec succès");
    }

    /**
     * @param CompanyMeetingRequest $request
     * @param $id
     * @return mixed
     */
    public function update(CompanyMeetingRequest $request, $id)
    {
        $rangeDate = explode(' => ', $request->date);
        $checker = new MeetingDatesCheckup(Carbon::createFromFormat('d/m/Y H:i', $rangeDate[0])->timestamp, Carbon::createFromFormat('d/m/Y H:i', $rangeDate[1])->timestamp);
        if (!$checker->isFree($id)) {
            return redirect()->back()->with('error', 'Un autre rendez-vous entre en conflit.')->withInput($request->all());
        }
        if (auth()->user()->isAdmin()) {
            $meeting = CompanyMeeting::where('id', $id)->firstOrFail();
        } else {
            $meeting = CompanyMeeting::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        }

        $meetingService = new CompanyMeetingService($request, $meeting);
        $meeting = $meetingService->save();

        return Redirect::route('users.meeting.search', ['user_id' => $meeting->user_id])
            ->with('success', "Le rendez-vous a été modifié avec succès");
    }

}
