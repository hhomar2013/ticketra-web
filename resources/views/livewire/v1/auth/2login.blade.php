<div class="row justify-content-center w-100">
    <div class="col-md-8 col-lg-6 col-xxl-4">
        <div class="card mb-0">
            <div class="card-body">
                <a class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="{{ asset('asset/images/cover.png') }}" style="width: 19rem;" alt="">
                </a>
                <p class="text-center">{{ config('app.name') ?? '' }}</p>
                <form wire:submit.prevent="login" class="mt-4">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="exampleInputEmail1" aria-describedby="emailHelp" wire:model="email">
                        <div class="invalid-feedback p-2 ">
                            <small><b> @error('email')
                                        {{ $message }}
                                    @enderror
                                </b>
                            </small>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="exampleInputPassword1" wire:model="password">
                        <div class="invalid-feedback p-2 ">
                            <small><b> @error('password')
                                        {{ $message }}
                                    @enderror
                                </b></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked"
                                checked wire:model.live="remember" />
                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                Remeber this Device
                            </label>
                        </div>
                        {{-- <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a> --}}
                    </div>
                    <button class="btn btn-primary w-100 py-8 fs-4 mb-4">{{ __('Sign In') }}</button><br>
                    <hr>
                    <div class="d-flex align-items-center justify-content-center">
                        <h6 class="fs-4 mb-0 fw-bold">©️ {{ date('Y') }} Developed by <a
                                href="https://hhomar2013.github.io/OmarMahgoub/" target="_blank">MTG.</a></h6>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
