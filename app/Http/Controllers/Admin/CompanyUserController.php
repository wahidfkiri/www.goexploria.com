<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddCompanyUserPostRequest;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Page;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\CompanyUser;
use App\Models\Coordinate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Collection;

class CompanyUserController extends Controller
{

    public function index($company)
    {
        $company = Company::find($company);
        $types = UserType::select(['id', 'name'])->get();
        $users = $company->users;
        return view('back.company.user.index', compact('company', 'users', 'types'));
    }

    // Company TYPE
    // GET ROUTES
    public function assigner($company)
    {
        $company = Company::find($company);
        $users = User::whereNotIn('id', $company->users()->select(['id'])->get()->pluck('id')->toArray())->select(['id', 'name'])->get();
        return view('back.company.user.assigner', compact('company', 'users'));
    }
    // Company TYPE
    // GET ROUTES
    public function add($company)
    {
        $company = Company::find($company);
        $types = UserType::orderBy('name')->pluck('name', 'id');
        return view('back.company.user.add', compact('company', 'types'));
    }

    public function store(AddCompanyUserPostRequest $request, $company)
    {
        $company = Company::findOrFail($company);
        $user_mails = $request->user_mail;

        if (is_array($user_mails)) {

            for ($u = 0; $u < count_of($user_mails); $u++) {
                try {
                    /** Génération d'un mot de passe */
                    $pass = $this->randomString(16);
                    $activationToken = $this->randomString(75);

                    // Création de la coordonnée
                    $coordinate = new Coordinate;
                    $coordinate->mail = $request->user_mail[$u];
                    $coordinate->tel = $request->user_tel[$u];
                    $coordinate->save();

                    // Génération des informations
                    $user = new User();
                    $user->name = $request->user_name[$u] != null ? $request->user_name[$u] : $request->user_first_name[$u] . " " . $request->user_last_name[$u];
                    $user->first_name = $request->user_first_name[$u];
                    $user->last_name = $request->user_last_name[$u];
                    $user->type_id = $request->user_type[$u];
                    $user->email = $request->user_mail[$u];
                    $user->is_activated = true;
                    $user->is_admin = false;
                    $user->activation_time = time();
                    $user->is_news_enabled = ((isset($request->user_news[$u])) && ($request->user_news[$u] != null));
                    $user->activation_token = md5($activationToken);
                    $user->reseted_password = Hash::make($pass);
                    $user->pass_secure = $user->reseted_password;
                    $user->coordinate_id = $coordinate->id;
                    $user->save();

                    $companyUser = new CompanyUser();
                    $companyUser->company_id = $company->id;
                    $companyUser->user_id = $user->id;
                    $companyUser->save();

                    $mail = $request->user_mail[$u];
                    $subject = "Bienvenue sur GoExploria";
                    Mail::send('mail.welcome', compact('user', 'activationToken', 'pass'), function ($message) use ($mail, $subject) {
                        $message->to($mail)->subject($subject);
                    });
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return Redirect::route('company.users.index', [
            $company
        ])->with('success', "La page  a été ajoutée avec succès");;
    }

    // POST ROUTES
    public function assign(Request $request, $company)
    {
        $user = $request->get('users');

        Company::find($company)->users()->attach($user);

        return Redirect::route('company.users.index', [
            $company
        ])->with('success', "La page  a été ajoutée avec succès");;
    }

    public function unassign($company, $user)
    {
        Company::find($company)->users()->detach($user);
        return Redirect::route('company.users.index', [$company])->with('info', "La user a bien été supprimée");
    }

    public function delete($company, $id)
    {
        Company::find($company)->users()->detach($id);
        return Redirect::route('company.users.search', [$company])->with('info', "La page a bien été supprimée");
    }

}
