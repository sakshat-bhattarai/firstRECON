<div>
    <div class="header">
        <div class="text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" class="logo align-middle my-auto">
            </a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card ms-5 me-5 mt-2" onclick="location.href='{{ route('ping') }}'"
                     style="cursor:pointer; min-height:410px">
                    <div class="card-body text-center">
                        <img src="{{ asset('ip-address.png') }}" class="mt-5 mr-5 ml-5 mb-2" width="100" height="100">
                        <div class="p-2">
                            <h5>Ping</h5>
                            <hr>
                        </div>
                        <p>
                            firstRECON can ping the targeted host with custom parameter provided by the user.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card ms-5 me-5 mt-2" onclick="location.href='{{ route('dns.lookup') }}'"
                     style="cursor:pointer; min-height:410px;">
                    <div class="card-body text-center">
                        <img src="{{ asset('dns.png') }}" class="mt-5 mr-5 ml-5 mb-2" width="100" height="100">
                        <div class="p-2">
                            <h5>DNS Lookup</h5>
                            <hr>
                        </div>
                        <p>
                            firstRECON can resolve DNS Record of the targeted host with ability to Lookup DNS record according to DNS record type.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card ms-5 me-5 mt-2" onclick="location.href='{{ route('port.scan') }}'"
                     style="cursor:pointer; min-height:410px">
                    <div class="card-body text-center">
                        <img src="{{ asset('radar.png') }}" class="mt-5 mr-5 ml-5 mb-2" width="100" height="100">
                        <div class="p-2">
                            <h5>Port Scan</h5>
                            <hr>
                            <p>
                                firstRECON can determine vulnerability exposer and exploit of the targeted host according to the services running in their open port.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                <div class="card ms-5 me-5 mt-4 pt-5">
                    <div class="card-body p-5">
                        <strong>Ping</strong>
                        <p>IP Ping tool sends a ping request to a domain, host, or IP and shows its response. This tool is handy if you want to check either a host is publicly accessible to everyone and responding correctly or not. The tool tests if a host computer that you are trying to access is operating or is accessible over the internet or not. It is also used for troubleshooting and to check the response time. A ping test runs to a server to check the latency between the computer running the ping test and the server. The IP Ping service sends several ICMP packets to the domain or IP and returns the detailed output. It tells how many packets were transmitted and how many were lost during the ping activity. First recon ping functionality is providing with the adjustable parameter and values to perform ping.</p>

                        <strong>DNS Lookup</strong>
                        <p>The DNS lookup tool fetches all the DNS records for a domain and reports them in a priority list. Use options to perform DNS lookup either against Google, Cloudflare, OpenDNS, or the domain's authoritative name server(s). Therefore, if you changed your web hosting or DNS records, those changes should reflect instantly. To check that you have configured correct DNS records for your domain, use the DNS lookup tool to verify your DNS records so you can avoid any downtime. The DNS records include A, AAAA, CNAME, MX, NS, PTR, SRV, SOA, TXT and CAA record.
                        <strong>Different Types of DNS Records</strong>
                           <p><strong>A record:</strong> the most basic type of record, also known as address record, provides an IPv4 address to a domain name or sub-domain name. That record points the domain name to an IP address.</p>
                           <p><strong>AAAA record:</strong> maps the hostname to 128-bits IPv6 address. For a long time, 32-bits IPv4 addresses served the purpose of identifying a computer on the internet. But due to the shortage of IPv4, IPv6 was created. The four "A" s (AAAA) are mnemonic to represent that IPv6 is four times larger in size than IPv4.</p>
                           <p><strong>CNAME record:</strong> also known as Canonical Name record, creates an alias of one domain name. The aliased domain or sub-domain gets all the original Domain's DNS records and is commonly used to associate subdomains with existing main domain.</p>
                           <p><strong>MX record:</strong> also known as Mail Exchange records, tells which mail exchange servers are responsible for routing the email to the correct destination or mail server.</p>
                           <p><strong>NS record:</strong> also known as Name Server records, points to the name servers which have authority in managing and publishing DNS records of that domain. These are the DNS servers that are authoritative to handle any query related to that domain.</p>
                           <p><strong>SRV record:</strong> also known as Service record, indicates which specific services the domain operates along with port numbers. Some Internet protocols such as the Extensible Messaging and Presence Protocol (XMPP) and the Session Initiation Protocol (SIP) often require SRV records.</p>
                           <p><strong>SOA record:</strong> also known as Start of Authority records, provides essential information about the domain like identifying master node of domain authoritative name server, an email of the domain administrator, the serial number of DNS zone, etc.</p>
                           <p><strong>TXT record:</strong> allows the website's administrator to insert any arbitrary text in the DNS record.</p>
                        <p><strong>CAA record:</strong> also known as Certification Authority Authorization record, reflects the public policy regarding the issuance of digital certificates for the domain. If no CAA record is present for your domain, any Certification Authority can issue an SSL certificate for your domain. However, by using this record, you can restrict which CA is authorized to issue digital credentials for your domain.</p>
                        </p>
                        <strong>Scan Ports</strong>
                        <p>Port Scanning are used for routing incoming information from a network to specific applications to a designated machine. Example, if you wanted to enable Remote Desktop on a Windows PC within your network, you'd need to make sure port 3389 was open and forwarding to the appropriate computer. Open ports are also used to determine if those open ports need to be closed to provide more network security and less vulnerabilities. firstRECON will provide you with information regarding valid methods of connecting to a network. Inbuilt port scanning feature of the web application is used to determine open port along with potential vulnerability and potential exploit of the intended service.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    <div class="content">--}}
    {{--        <div class="card">--}}
    {{--            <div class="card-body p-4">--}}
    {{--                <div class="text-center">--}}
    {{--                    <p>--}}
    {{--                        firstRECON is a port scanning tool--}}
    {{--                    </p>--}}
    {{--                    <hr>--}}
    {{--                    <a href="{{ route('home') }}" class="text-decoration-none m-2">Home</a>--}}
    {{--                    <a href="{{ route('home') }}" class="text-decoration-none m-2">DNS Lookup</a>--}}
    {{--                </div>--}}
    {{--                <div class="form-group mt-3">--}}
    {{--                    <label for="hostname" class="form-label">Domain/IP</label>--}}
    {{--                    --}}{{--                <div class="input-group">--}}
    {{--                    <input type="text" id="hostname" class="form-control form-control-lg" placeholder="Enter Url Here"--}}
    {{--                           wire:model="hostname">--}}
    {{--                    --}}{{--                    <div class="input-group-append">--}}
    {{--                    --}}{{--                        <button class="btn btn-lg btn-success text-white input-group-button" wire:click="ping">--}}
    {{--                    --}}{{--                            Ping--}}
    {{--                    --}}{{--                        </button>--}}

    {{--                    --}}{{--                    </div>--}}
    {{--                    @error('hostname') <span class="error">{{ $message }}</span> @enderror--}}
    {{--                    --}}{{--                </div>--}}


    {{--                </div>--}}
    {{--                <div class="form-group mt-3">--}}
    {{--                    <label for="port_type" class="form-label">Package</label>--}}
    {{--                    <select id="port_type" class="form-control form-control-lg" wire:model="port_type">--}}
    {{--                        <option value="">Choose</option>--}}
    {{--                        @foreach($portTypes as $type => $ports)--}}
    {{--                            <option value="{{ $type }}">{{ $type }} ({{ implode(',',$ports) }})</option>--}}
    {{--                        @endforeach--}}
    {{--                    </select>--}}
    {{--                </div>--}}
    {{--                <div class="form-group mt-3 text-center">--}}
    {{--                    <button class="btn btn-success btn-lg text-white" id="scan" wire:click="submit">--}}
    {{--                        Scan--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                --}}{{--            <div wire:loading wire:target="ping">--}}
    {{--                --}}{{--                <div class="bg-dark text-white">--}}
    {{--                --}}{{--                    {{ $pingResult }}--}}
    {{--                --}}{{--                </div>--}}
    {{--                --}}{{--            </div>--}}

    {{--                <div class="text-center mt-4">--}}

    {{--                    <div wire:loading wire:target="submit">--}}
    {{--                        <i class="fas fa-lg fa-spinner fa-pulse" style="font-size:100px;"></i>--}}
    {{--                        <br>--}}
    {{--                        <br>--}}
    {{--                        <strong>Scanning Ports</strong>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            --}}{{--        @if(count($openPorts) < 0)--}}
    {{--            <div class="text-center fw-bold">--}}
    {{--                <h4>Open Ports</h4>--}}
    {{--            </div>--}}
    {{--            <div class="row">--}}
    {{--                @foreach($openPorts as $port)--}}

    {{--                    <div class="col-sm-12 col-md-12 col-lg-12">--}}
    {{--                        <div class="card bg-light m-3">--}}
    {{--                            <div class="card-body p-4">--}}
    {{--                                <h5>--}}
    {{--                                    <strong>--}}
    {{--                                        Port {{ $port->port }} is open--}}
    {{--                                    </strong>--}}
    {{--                                </h5>--}}
    {{--                                @if($port->cves->count() > 0)--}}
    {{--                                    <p>--}}
    {{--                                        @foreach($port->cves as $cve)--}}
    {{--                                            <a href="{{ $cve->link }}" target="_blank">{{ $cve->cve }}</a>--}}
    {{--                                            @if(!$loop->last)--}}
    {{--                                                ,--}}
    {{--                                            @endif--}}
    {{--                                        @endforeach--}}
    {{--                                    </p>--}}
    {{--                                @endif--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--            --}}{{--        @else--}}
    {{--            --}}{{--            <div class="text-center fw-bold">--}}
    {{--            --}}{{--                <h4>--}}
    {{--            --}}{{--                    No open ports found--}}
    {{--            --}}{{--                </h4>--}}
    {{--            --}}{{--            </div>--}}
    {{--            --}}{{--        @endif--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        //     $('#scan').on('click',function (){
        //         Livewire.emit('setHostname',document.getElementById('host').value)
        //         Livewire.on('hostAdded',function (){
        //             $('#results').show()
        //             var buttons = document.getElementsByClassName('submit_button')
        //             for (let item of buttons) {
        //                 document.getElementById(item.id).click()
        //             }
        //         })
        //
        //     })
    });
</script>
