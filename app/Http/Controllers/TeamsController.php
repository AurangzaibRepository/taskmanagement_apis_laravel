<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Inertia\Inertia;
use Inertia\Response;

class TeamsController extends Controller
{
    public function __construct(
        private Team $team
    ) {
    }

    public function index(): Response
    {
        $teamList = $this->team->getListing();

        return Inertia::render('Teams/Index', [
            'teams' => $teamList,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Teams/Create');
    }
}
