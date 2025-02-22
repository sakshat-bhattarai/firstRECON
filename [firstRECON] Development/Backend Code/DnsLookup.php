<?php

namespace App\Http\Livewire;

use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Spatie\Dns\Dns;

class DnsLookup extends Component
{
    public $hostname;
    public $recordTypes;
    public $record_type = "All";
    public $specifiedRecord;
    public $results = [];
    public $currentStep = 1;
    public $buttonWidth;

    protected $listeners = [
        'getButtonWidth'
    ];

    public function render()
    {
        $this->recordTypes = [
            'A' => 'A',
            'AAAA' => 'AAAA',
            'CNAME' => 'CNAME',
            'NS' => 'NS',
            'SOA' => 'SOA',
            'MX' => 'MX',
            'SRV' => 'SRV',
            'TXT' => 'TXT',
            'CAA' => 'CAA',
        ];
        return view('livewire.dns-lookup');
    }

    public function lookup()
    {
        $this->validate([
           'hostname' => 'required'
        ]);
        $results = [];
        if($this->record_type == "All"){
            foreach($this->recordTypes as $recordType){
                try {
                    $results[$recordType] = $this->process($recordType);
                }catch(\Exception $exception){
                    $results[$recordType] = [];
                }
            }
        }else{
            try {
                $results[$this->record_type] = $this->process($this->record_type);

            }catch(\Exception $exception) {
                $results[$this->record_type] = [];
            }
        }
        $this->results = $results;
        $this->currentStep = 2;
    }

    public function process($type)
    {
        $dns = new Dns();
        return $dns->getRecords($this->hostname, $type);
    }

    public function exportPdf()
    {
        $data = [
            'host' => $this->hostname,
            'results' => $this->results
        ];
        $pdfContent = PDF::loadView('dns-pdf', $data)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "dns-lookup-result.pdf"
        );
    }

    public function getButtonWidth($value)
    {
        $this->buttonWidth = $value / 10 ;
    }
}
