<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ParticipantsTable extends Component
{
    public $participants;
    public $exportRoute;

    public function __construct($participants, $exportRoute)
    {
        $this->participants = $participants;
        $this->exportRoute = $exportRoute;
    }

    public function render()
    {
        return view('components.participants-table');
    }
}