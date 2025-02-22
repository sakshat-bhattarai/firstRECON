<div>
    <div wire:loading wire:target="submit">
        <div id="overlay">
            <div class="text-center">
                <div class="my-auto">
                    <i class="fas fa-lg text-white fa-spinner fa-pulse " style="font-size:100px;"></i>
                    <br>
                    <br>
                    <div class="text-white">
                        <strong>Scanning Ports</strong>
                    </div>
                    <br>
                    <a href="{{ route('port.scan') }}" class="ms-3 btn btn-danger btn-lg text-white" >
                        Stop Scan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" class="logo align-middle my-auto">
            </a>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body p-4">
                    <h1>Port Scan</h1>
                <div @if($currentStep !== 1) style="display: none" @endif >
                    <div class="form-group mt-3">
                        <label for="hostname" class="form-label fw-bold">Enter any valid IP/Url</label>
                        <input type="text" id="hostname" class="form-control form-control-lg" placeholder="Enter Url Here"
                               wire:model="hostname">
                        @error('hostname') <span class="error">{{ $message }}</span> @enderror


                    </div>
                    <label for="port_type" class="mt-4 form-label fw-bold">Select Type of Scan</label>
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                                <button class=" btn btn-lg btn-outline-primary @if($port_type !== "custom_port" && $port_type !== "port_range") active @endif" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" style="width:{{ $buttonWidth }}px">Package</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class=" btn btn-lg btn-outline-primary @if($port_type === "custom_port") active @endif" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false" wire:click="$set('port_type','custom_port')" style="width:{{ $buttonWidth }}px">Custom Port</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class=" btn btn-lg btn-outline-primary @if($port_type === "port_range") active @endif" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" wire:click="$set('port_type','port_range')" style="width:{{ $buttonWidth }}px">Range</button>
                            </li>
                        </ul>
                    <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if($port_type !== "custom_port" && $port_type !== "port_range") show active @endif" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <select id="port_type" class="form-control form-control-lg" wire:model="port_type">
                                    <option value="">Choose Package</option>
                                    @foreach($portTypes as $type => $ports)
                                        <option value="{{ $type }}">{{ $type }} ({{ implode(',',$ports) }})</option>
                                    @endforeach
                                </select>
                                @error('port_type') <span class="error">{{ $message }}</span> @enderror

                            </div>
                            <div class="tab-pane fade @if($port_type === "custom_port") show active @endif" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                @if($customPorts)
                                    <input type="text" id="specifiedPorts" class="form-control form-control-lg mt-3" placeholder="Ex. 22,80,443"
                                           wire:model="specifiedPorts">
                                    @error('specifiedPorts') <span class="error">{{ $message }}</span> @enderror
                                @endif
                            </div>
                            <div class="tab-pane fade @if($port_type === "port_range") show active @endif" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                @if($portRange)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <input type="text" id="portFrom" class="form-control form-control-lg mt-3" placeholder="Port From"
                                                   wire:model="portFrom">
                                            @error('portFrom') <span class="error">{{ $message }}</span> @enderror

                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <input type="text" id="portTo" class="form-control form-control-lg mt-3" placeholder="Port To"
                                                   wire:model="portTo">
                                            @error('portTo') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>

                    <div class="form-group mt-5 text-center">
                        <button class="btn btn-success btn-lg text-white" id="scan" wire:click="submit">
                            Scan
                        </button>
                    </div>
                </div>
            </div>
            <div @if($currentStep !== 2) style="display: none" @endif class="p-4">
                <div class="mb-5">
                    <div class="float-end">
                        <a wire:click="generatePdf"  class="btn btn-success text-white">Generate PDF</a>
                        <a wire:click="generateExcel"  class="btn btn-success text-white">Export To Excel</a>
                        <a href="{{ route('port.scan') }}"  class="btn btn-success text-white">Scan Another Host</a>
                    </div>
                    <div class="float-start">
                        <h3>Port Scan Results For : <span class="text-success">{{ $hostname }}</span></h3>
                    </div>
                </div>

            @if($formattedResult)

                    <div class="row" wire:loading.remove>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <table class="table table-striped">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Port</th>
                                        <th>State</th>
                                        <th>Service</th>
                                        <th>Version</th>
                                        <th>Reason</th>
                                        <th>CVE & Exploits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($formattedResult as $openPort)
                                        @include('components.port-scan-result',['openPort' =>  $openPort])
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
<script>
    function openCve(id){
        document.getElementById(id).style.display = 'block';
    }
    $(document).ready(function (){
        let hostnameWidth = document.getElementById('hostname').offsetWidth;
        Livewire.emit('getButtonWidth', hostnameWidth);
    })
</script>
