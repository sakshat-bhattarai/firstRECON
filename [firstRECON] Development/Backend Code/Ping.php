<?php

namespace App\Http\Livewire;

use Acamposm\Ping\PingCommandBuilder;
use Livewire\Component;

class Ping extends Component
{
    public $hostname;
    public $currentStep = 1;
    public $results =[];
    public $count;
    public $packet;
    public $interval;
    public $timeout;

    public function mount()
    {
        $this->count = 4;
        $this->packet = 64;
        $this->interval = 128;
        $this->timeout = 4000;
    }

    public function render()
    {

        return view('livewire.ping');
    }

    public function submit()
    {
        $this->validate([
            'hostname' => 'required',
            'count' => 'required',
            'packet' => 'required',
            'interval' => 'required',
            'timeout' => 'required',
        ]);

        $hostname = explode(' ',$this->hostname);
        $ping = exec('ping -n '.$this->count.' -i '.$this->interval.' -w '.$this->timeout.' -l '.$this->packet.' '.$hostname[0], $output);
        $this->results = $output;
        $this->currentStep = 2;
    }

}
