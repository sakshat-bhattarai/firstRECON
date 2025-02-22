<div>
    <div wire:loading wire:target="lookup">
        <div id="overlay">
            <div class="text-center">
                <div class="my-auto">
                    <i class="fas fa-lg text-white fa-spinner fa-pulse " style="font-size:100px;"></i>
                    <br>
                    <br>
                    <div class="text-white">
                        <strong>Please Wait</strong>
                    </div>
                    <br>
                    <a href="{{ route('dns.lookup') }}" class="ms-3 btn btn-danger btn-lg text-white" >
                        Stop DNS Lookup
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
        <div class="card" >
            <div class="card-body p-4">
                    <h1>DNS Lookup</h1>
                <div @if($currentStep !== 1) style="display: none" @endif>
                    <div class="form-group mt-3">
                        <label for="hostname" class="form-label fw-bold">Enter any valid IP/Url</label>
                        <input type="text" id="hostname" class="form-control form-control-lg" placeholder="Enter Url Here"
                               wire:model="hostname">
                        @error('hostname') <span class="error">{{ $message }}</span> @enderror


                    </div>
                    <div class="form-group mt-3">
                        <label for="record_type" class="form-label fw-bold">Select Record Type</label>
                        <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button wire:click="$set('record_type','All')" class=" btn btn-lg btn-outline-primary @if($record_type === "All") active @endi" fid="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" style="width:{{ $buttonWidth }}px">All</button>
                            </li>
                            @foreach($recordTypes as $type)
                                <li class="nav-item" role="presentation">
                                    <button wire:click="$set('record_type','{{ $type }}')" class="btn btn-lg btn-outline-primary @if($record_type === $type) active @endif" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" style="width:{{ $buttonWidth }}px">
                                        {{$type}}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success btn-lg text-white" id="scan" wire:click="lookup">
                            Lookup DNS
                        </button>
                    </div>

                </div>
                <div @if($currentStep !== 2)  class="p-4" style="display: none" @endif>
                    <div>
                       <div class="float-end">
{{--                           <a onclick="print()"  class="btn btn-success text-white">Generate PDF</a>--}}
                           <a href="{{ route('dns.lookup') }}"  class="btn btn-success text-white">Lookup Another Domain</a>
                       </div>
                       <div class="float-start">
                           <h3>DNS Results For : <span class="text-success">{{ $hostname }}</span></h3>
                       </div>
                   </div>
                    @if($results)
                        <div class="pt-5" wire:ignore>
                            @foreach($results as $type => $result)
                                <div class="mt-5 mb-5">
                                    @if($type == "A")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="4">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th>Type</th>
                                                <th>Domain Name</th>
                                                <th>TTL</th>
                                                <th>Address</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                <tr>
                                                    <td>{{ $type }}</td>
                                                    <td>{{ $record->host() }}</td>
                                                    <td>{{ $record->ttl() }}</td>
                                                    <td>{{ $record->ip() }}</td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type == "AAAA")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="4">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Address</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                <tr>
                                                    <td colspan="1">{{ $type }}</td>
                                                    <td colspan="1">{{ $record->host() }}</td>
                                                    <td colspan="1">{{ $record->ttl() }}</td>
                                                    <td colspan="1">{{ $record->ipv6() }}</td>
                                                </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type == "CNAME")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="4">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Value</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->target() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type === "NS")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="4">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Canonical Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->target() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type === "SOA")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="5">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Primary NS</th>
                                                <th colspan="1">Responsible Email</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->mname() }}</td>
                                                        <td colspan="1">{{ $record->rname() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type === "MX")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="5">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Preference</th>
                                                <th colspan="1">Address</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->pri() }}</td>
                                                        <td colspan="1">{{ $record->target() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type === "SRV")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="75">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Preference</th>
                                                <th colspan="1">Weight</th>
                                                <th colspan="1">Port</th>
                                                <th colspan="1">Target</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->pri() }}</td>
                                                        <td colspan="1">{{ $record->weight() }}</td>
                                                        <td colspan="1">{{ $record->port() }}</td>
                                                        <td colspan="1">{{ $record->target() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type === "TXT")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="4">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Record</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->txt() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @elseif($type === "CAA")
                                        <table class="table">
                                            <thead>
                                            <tr class="custom-tr text-center">
                                                <th colspan="6">
                                                    <h4>{{ $type }}</h4>
                                                </th>
                                            </tr>
                                            <tr class="bg-dark text-white">
                                                <th colspan="1">Type</th>
                                                <th colspan="1">Domain Name</th>
                                                <th colspan="1">TTL</th>
                                                <th colspan="1">Flags</th>
                                                <th colspan="1">Tag</th>
                                                <th colspan="1">Value</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                                @foreach($result as $record)
                                                    <tr>
                                                        <td colspan="1">{{ $type }}</td>
                                                        <td colspan="1">{{ $record->host() }}</td>
                                                        <td colspan="1">{{ $record->ttl() }}</td>
                                                        <td colspan="1">{{ $record->flags() }}</td>
                                                        <td colspan="1">{{ $record->tag() }}</td>
                                                        <td colspan="1">{{ $record->value() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center">Sorry no records found !</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function (){
        let hostnameWidth = document.getElementById('hostname').offsetWidth;
        Livewire.emit('getButtonWidth', hostnameWidth);
    })
</script>
