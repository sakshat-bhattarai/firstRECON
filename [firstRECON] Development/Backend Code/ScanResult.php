<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ScanResult extends Component
{
//    public $results = [];
    protected $listeners = ['portScanned' => '$refresh'];

//    public function portScanned($results)
//    {
//        $this->results[] = $results;
//        $this->emitTO('scan-result','$refresh');
//    }

    public function render()
    {
        return view('livewire.scan-result');
    }
}
