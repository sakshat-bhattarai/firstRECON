<?php

namespace App\Http\Livewire;

use App\Exports\PortExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PortScan extends Component
{
    /*
     * Declare Public Variables
     * */
    public $hostname;   //Stores the hostname entered by user
    public $portTypes = []; // Stores the array of package
    public $port_type; // Stores the port type selected by user
    public $specifiedPorts = []; //Stores specified ports in custom scanning
    public $openPorts = []; //Stores open port after result is obtained
    public $formattedResult; //Stores formatted result after manipulating the obtained result
    public $currentStep = 1; // Stores the current step for input interface and result interface
    public $customPorts = false; // Stores boolean for custom port scan. If custom port is entered the value will be true
    public $portRange = false; // Stores boolean for range scan. If range is entered the value will be true
    public $singlePort = false; // Becomes true if only single port is scanned or obtained
    public $exportData; // Stores formatted data for pdf export
    public $portFrom; // Stores port from for range scan
    public $portTo; // Stores port to for range scan
    public $buttonWidth;

    protected $listeners = [
        'getButtonWidth'
    ];
    /*
     * This function mounts data into view on load. This function doesn't reload unless the page is reloaded .
     */
    public function mount()
    {
        //Package Types
        $this->portTypes = [
            'Well Known Ports'	=> [20, 21 ,22, 23, 25, 53, 80, 110, 115, 123, 143, 161, 194, 443, 445, 465, 554, 873, 993, 995, 3389, 5631, 3306, 5432, 5900, 6379, 11211, 25565],
            'Basic' => [21,22,25,26,2525,587,80,443,110,995,143,993,3306],
            'Game Port' => [1725,2302,3074,3724,6112,6500,12035,12036,14567,25565,27015,28960],
            'Malicious Port' =>[1080, 3127, 2745, 4444, 5554, 8866, 9898, 9988, 12345, 27374, 31337],
            'P2P' => [34320, 34322, 34323, 34331, 34333, 34339, 34341, 34324, 34325, 34335, 34337, 34760, 34750, 34545, 34546]
        ];

        //Check for port type
        if ($this->port_type) {
            if ($this->port_type === "custom_port") {
                $this->customPorts = true;
            } else if ($this->port_type === "port_range") {
                $this->portRange = true;
            } else {
                $this->specifiedPorts = $this->portTypes[$this->port_type];
            }

        }
    }

    /*
     * Render the main view
     */
    public function render()
    {
        //Check for port type
        if ($this->port_type) {
            if ($this->port_type === "custom_port") {
                $this->customPorts = true;
            } else if ($this->port_type === "port_range") {
                $this->portRange = true;
            } else {
                $this->specifiedPorts = $this->portTypes[$this->port_type];
            }

        }

        return view('livewire.port-scan');
    }

    //Check for port type
    public function getSpecifiedPorts()
    {
        if ($this->port_type == "custom_port") {
            $this->customPorts = true;
        } else if ($this->port_type === "port_range") {
            $this->portRange = true;
        } else {
            return $this->portTypes[$this->port_type];
        }
    }

    //This function performs scanning and manipulation of result
    public function submit()
    {
        //Initiate open ports array
        $this->openPorts = [];

        //Validate the user input
        $this->validate([
            'hostname' => 'required',
            'port_type' => 'required'
        ]);

        //Check for scanning conditions
        if ($this->portRange) {
            //If range scan validate input for range scan
            $this->validate([
                'portFrom' => 'required|numeric',
                'portTo' => 'required|numeric'
            ]);

            //Perform Range Scan From Given Input Using Nmap and export the result in xml file
            $scan = shell_exec('nmap -oX nmapresult.xml ' . $this->hostname . ' -sV -p ' . $this->portFrom . '-' . $this->portTo);
        } else {
            $this->validate([
                'specifiedPorts' => 'required'
            ]);
            //Mani
            $specifiedPorts = is_array($this->specifiedPorts) == true ? implode(',', $this->specifiedPorts) : str_replace(' ', '', $this->specifiedPorts);

            //Perform Range Scan From Given Input Using Nmap and export the result in xml file
            $scan = shell_exec('nmap -oX nmapresult.xml ' . $this->hostname . ' -sV -p ' . $specifiedPorts);
        }
        if ($scan) {
            $loadXml = simplexml_load_file('nmapresult.xml');
            $convertToJson = json_encode($loadXml);
            $convertToArray = json_decode($convertToJson, TRUE);
            try {
                if (!$this->portRange) {
                    if (count(explode(',', $specifiedPorts)) === 1) {
                        $this->singlePort = true;
                    }
                }
                $this->openPorts = $convertToArray['host']['ports']['port'];

                if (!isset($convertToArray['host']['ports']['port'][0])) {
                    $this->singlePort = true;
                }

                $formattedResults = [];
                if ($this->singlePort) {
                    $openPort = $this->openPorts;
                    $formattedResults[$openPort['@attributes']['portid']]['port'] = $port = $openPort['@attributes']['portid'];
                    $formattedResults[$openPort['@attributes']['portid']]['state'] = $state = $openPort['state']['@attributes']['state'];
                    $formattedResults[$openPort['@attributes']['portid']]['service'] = $service = isset($openPort['service']['@attributes']['name']) ? $openPort['service']['@attributes']['name'] : '-';
                    $formattedResults[$openPort['@attributes']['portid']]['product'] = $product = isset($openPort['service']['@attributes']['product']) ? $openPort['service']['@attributes']['product'] : null;
                    $formattedResults[$openPort['@attributes']['portid']]['version'] = $version = isset($openPort['service']['@attributes']['version']) ? $openPort['service']['@attributes']['version'] : null;
                    $formattedResults[$openPort['@attributes']['portid']]['extrainfo'] = $extrainfo = isset($openPort['service']['@attributes']['extrainfo']) ? $openPort['service']['@attributes']['extrainfo'] : null;
                    $formattedResults[$openPort['@attributes']['portid']]['reason'] = $reason = $openPort['state']['@attributes']['reason'];
                    $cves = [];
                    $exploits = [];
                    //Scan for cves
                    if ($state == "open" && $product !== null) {
                        $url = 'https://services.nvd.nist.gov/rest/json/cves/1.0/?apiKey=3eee8117-84b7-481b-bea1-a7ef6c4896d7&keyword=' . urlencode($product) . '&isExactMatch=true';
//                        $getCveResponse = file_get_contents('https://services.nvd.nist.gov/rest/json/cves/1.0/?apiKey=3eee8117-84b7-481b-bea1-a7ef6c4896d7&keyword=' . $product . '&isExactMatch=true');
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                        $getCveResponse = curl_exec($ch);
                        $response = json_decode($getCveResponse, true);
                        if ($response['totalResults'] > 0) {

                            foreach ($response['result']['CVE_Items'] as $cveItem) {
                                $cves[] = [
                                    'cve' => $cveItem['cve']['CVE_data_meta']['ID'],
                                    'description' => $cveItem['cve']['description']['description_data'][0]['value'],
                                ];
                            }
                        }

                        //fetch exlpoits
                        $exploitUrl = 'https://serpapi.com/search.json?engine=google&q=site%3Aexploit-db.com+' . urlencode($product) . '&google_domain=google.com&gl=us&hl=en&num=5&api_key=82bc16c6ce8fda6bb52ed85af2ce92983684f211b14073ce33c82ab37626f0ed';
                        $exploit_ch = curl_init($exploitUrl);
                        curl_setopt($exploit_ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($exploit_ch, CURLOPT_BINARYTRANSFER, true);
                        $getExploitResponse = curl_exec($exploit_ch);
                        $exploitResponse = json_decode($getExploitResponse, true);
                        if (isset($exploitResponse['organic_results']) && count($exploitResponse['organic_results']) > 0) {
                            foreach ($exploitResponse['organic_results'] as $result) {
                                $exploits[] = [
                                    'title' => $result['title'],
                                    'link' => $result['link']
                                ];
                            }
                        }
                    }
                    $formattedResults[$openPort['@attributes']['portid']]['cves'] = $cves;
                    $formattedResults[$openPort['@attributes']['portid']]['exploits'] = $exploits;
                } else {
                    foreach ($this->openPorts as $openPort) {
                        $formattedResults[$openPort['@attributes']['portid']]['port'] = $port = $openPort['@attributes']['portid'];
                        $formattedResults[$openPort['@attributes']['portid']]['state'] = $state = $openPort['state']['@attributes']['state'];
                        $formattedResults[$openPort['@attributes']['portid']]['service'] = $service = isset($openPort['service']['@attributes']['name']) ? $openPort['service']['@attributes']['name'] : '-';
                        $formattedResults[$openPort['@attributes']['portid']]['product'] = $product = isset($openPort['service']['@attributes']['product']) ? $openPort['service']['@attributes']['product'] : null;
                        $formattedResults[$openPort['@attributes']['portid']]['version'] = $version = isset($openPort['service']['@attributes']['version']) ? $openPort['service']['@attributes']['version'] : null;
                        $formattedResults[$openPort['@attributes']['portid']]['extrainfo'] = $extrainfo = isset($openPort['service']['@attributes']['extrainfo']) ? $openPort['service']['@attributes']['extrainfo'] : null;
                        $formattedResults[$openPort['@attributes']['portid']]['reason'] = $reason = $openPort['state']['@attributes']['reason'];
                        //Scan for cves
                        $cves = [];
                        $exploits = [];

                        if ($state == "open" && $product !== null) {
                            $url = 'https://services.nvd.nist.gov/rest/json/cves/1.0/?apiKey=3eee8117-84b7-481b-bea1-a7ef6c4896d7&keyword=' . $product . '&isExactMatch=true';
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                            $getCveResponse = curl_exec($ch);
//                                $getCveResponse = file_get_contents($url);
                            $response = json_decode($getCveResponse, true);
                            if (isset($response['totalResults']) && $response['totalResults'] > 0) {
                                foreach ($response['result']['CVE_Items'] as $cveItem) {
                                    $cves[] = [
                                        'cve' => $cveItem['cve']['CVE_data_meta']['ID'],
                                        'description' => $cveItem['cve']['description']['description_data'][0]['value'],
                                    ];
                                }
                            }

                            //fetch exlpoits
                            $exploitUrl = 'https://serpapi.com/search.json?engine=google&q=site%3Aexploit-db.com+' . $product . '&google_domain=google.com&gl=us&hl=en&num=5&api_key=82bc16c6ce8fda6bb52ed85af2ce92983684f211b14073ce33c82ab37626f0ed';
                            $exploit_ch = curl_init($exploitUrl);
                            curl_setopt($exploit_ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($exploit_ch, CURLOPT_BINARYTRANSFER, true);
                            $getExploitResponse = curl_exec($exploit_ch);
                            $exploitResponse = json_decode($getExploitResponse, true);
                            if (isset($exploitResponse['organic_results']) && count($exploitResponse['organic_results']) > 0) {
                                foreach ($exploitResponse['organic_results'] as $result) {
                                    $exploits[] = [
                                        'title' => $result['title'],
                                        'link' => $result['link']
                                    ];
                                }
                            }

                        }
                        $formattedResults[$openPort['@attributes']['portid']]['cves'] = $cves;
                        $formattedResults[$openPort['@attributes']['portid']]['exploits'] = $exploits;

                    }
                }
                $this->formattedResult = $formattedResults;
                $this->exportData = [
                    'host' => $this->hostname,
                    'openPorts' => $this->formattedResult
                ];
                $file = fopen("formatted-results.json", "w");
                fwrite($file, json_encode($this->exportData));
                fclose($file);
                $this->currentStep = 2;
            } catch (\Exception $exception) {
                dd($exception);
            }
        }

    }

    public function generatePdf()
    {

        $pdfContent = PDF::loadView('port-scan-pdf', $this->exportData)->output();
        return response()->streamDownload(
            fn() => print($pdfContent),
            "port-scan-result.pdf"
        );
    }

    public function generateExcel()
    {
        return Excel::download(new PortExport, 'portscan.xlsx');
    }
    public function getButtonWidth($value)
    {
        $this->buttonWidth = $value / 3 ;
    }
}
