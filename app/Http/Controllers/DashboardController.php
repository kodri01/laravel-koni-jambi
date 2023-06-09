<?php

namespace App\Http\Controllers;

use App\Models\Atlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Spatie\Permission\Models\Role;
use App\Models\Club;
use App\Models\GamesModel;
use App\Models\EventsModel;
use App\Models\AwardsModel;
use App\Models\Cabor;
use App\Models\News;
use App\Models\Pelatih;
use App\Models\TeamModel;
use App\Models\RequestAtlets;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        # code...
        $this->middleware(['permission:dashboards']);
    }

    public function index()
    {
        # code...
        // return dd(auth()->user()->id);
        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        $users = User::count();
        $cabor = Cabor::count();
        $atlet = Atlet::count();
        $event = EventsModel::count();
        $team = TeamModel::count();
        $club = Club::count();
        $award = AwardsModel::count();
        $pelatih = Pelatih::count();
        $game  = GamesModel::count();
        $teamm = TeamModel::orderBy('id', 'asc')->get();
        $clubb = Club::orderBy('id', 'asc')->get();


        $awards = AwardsModel::where('cabang_id', auth::user()->cabang_id)->get();
        $events = EventsModel::where('cabang_id', auth::user()->cabang_id)->get();
        $news = News::where('cabang_id', auth::user()->cabang_id)->get();
        $games  = GamesModel::where('cabang_id', auth::user()->cabang_id)->get();
        $clubs = Club::where('cabang_id', auth::user()->cabang_id)->get();
        $teams = TeamModel::where('cabang_id', auth::user()->cabang_id)->get();
        if ($role->name == 'superadmin') {
            return view('pages.dashboard.leader', compact('event',  'club',  'team', 'clubb',  'teamm', 'pelatih', 'game', 'award', 'users', 'cabor', 'atlet'));
        } else {
            return view('pages.dashboard.dashboard', compact('news', 'awards', 'events', 'games', 'clubs'));
        }
    }

    public function eventview($slug)
    {
        # code...
        $event = EventsModel::where('slug', $slug)->first();
        $startDate = Carbon::parse($event->start_date)->format('d/m/Y');
        $endDate = Carbon::parse($event->end_date)->format('d/m/Y');
        return view('pages.dashboard.dash_event', compact('event', 'startDate', 'endDate'));
    }

    public function gameview($slug)
    {
        # code...
        $game = GamesModel::where('slug', $slug)->first();
        return view('pages.dashboard.dash_game', compact('game'));
    }

    public function awardview($slug)
    {
        # code...
        $award = AwardsModel::where('slug', $slug)->first();
        return view('pages.dashboard.dash_award', compact('award'));
    }

    public function joinclub($slug)
    {
        # code...
        $club = Club::where('slug', $slug)->first();
        return view('pages.dashboard.dash_club', compact('club'));
    }

    public function joinclubInsert($slug)
    {
        # code...
        $club = Club::where('slug', $slug)->first();

        RequestAtlets::create([
            'user_id' => auth()->user()->id,
            'club_id' => $club->id
        ]);
        return redirect()->to('dashboard/joinClub/' . $slug)
            ->with('success', 'Success request join club');
    }
}
