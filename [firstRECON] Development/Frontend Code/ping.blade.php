<div>
    <div wire:loading wire:target="submit">
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
                    <a href="{{ route('ping') }}" class="ms-3 btn btn-danger btn-lg text-white" >
                        Stop Ping
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
                    <h1>Ping</h1>
                <div @if($currentStep !== 1) style="display: none" @endif >
                    <div class="form-group mt-3">
                        <label for="hostname" class="form-label fw-bold">Enter any valid IP/Url</label>
                        <input type="text" id="hostname" class="form-control form-control-lg" placeholder="Enter Url Here"
                               wire:model="hostname">
                        @error('hostname') <span class="error">{{ $message }}</span> @enderror


                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <label for="count" class="form-label fw-bold">Count</label>
                            <input type="number" id="count" class="form-control form-control-lg" placeholder="Count"
                                   wire:model="count">
                            @error('count') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <label for="packet" class="form-label fw-bold">Packet Size</label>
                            <input type="number" id="packet" class="form-control form-control-lg" placeholder="Packet Size"
                                   wire:model="packet">
                            @error('packet') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <label for="interval" class="form-label fw-bold">Interval</label>
                            <input type="number" id="interval" class="form-control form-control-lg" placeholder="Interval"
                                   wire:model="interval">
                            @error('interval') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <label for="timeout" class="form-label fw-bold">Timeout</label>
                            <input type="number" id="timeout" class="form-control form-control-lg" placeholder="Timeout"
                                   wire:model="timeout">
                            @error('timeout') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group mt-3 text-center">
                        <button class="btn btn-success btn-lg text-white" id="ping" wire:click="submit">
                            Ping
                        </button>
                    </div>
                </div>

            <div @if($currentStep !== 2) style="display: none" @endif class="p-4">
                <div class="mb-5">
                    <div class="float-end">
                        <a href="{{ route('ping') }}"  class="btn btn-success text-white">Ping Another Host</a>
                    </div>
                    <div class="float-start">
                        <h3>Ping Result For : <span class="text-success">{{ $hostname }}</span></h3>
                    </div>
                </div>
                @if($results)
                    <div class="card">
                        <div class="card-body bg-dark text-white">
                            @foreach($results as $result)
                                {{ $result }}<br>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body bg-dark text-white">
                            ping: cannot resolve {{ $hostname }}: Unknown host
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
