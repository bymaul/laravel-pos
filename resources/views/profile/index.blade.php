@section('title', 'Profil')

<x-app-layout>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Profile</h3>
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4"
                            src="{{ asset('assets/img/avatars/avatar1.jpeg') }}"" width="160" height="160">
                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Change Photo</button>
                        </div>
                    </div>
                </div>
                <div class="card bg-primary text-light shadow mb-4">
                    <div class="card-body text-center">
                        @if ($user->role == 'admin')
                            <strong>Administrator</strong>
                        @else
                            <strong>Kasir</strong>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Pengaturan Pengguna</p>
                            </div>
                            <div class="card-body">
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>

                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-sm col-12">
                                            <div class="mb-3"><label class="form-label"
                                                    for="name"><strong>Nama</strong></label><input
                                                    class="form-control" type="text" id="name"
                                                    placeholder="Nama Pengguna" name="name"
                                                    value="{{ old('name', $user->name) }}">
                                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                            </div>
                                        </div>
                                        <div class="col-sm col-12">
                                            <div class="mb-3"><label class="form-label"
                                                    for="email"><strong>Email</strong></label><input
                                                    class="form-control" type="email" id="email"
                                                    placeholder="Email Pengguna" name="email"
                                                    value="{{ old('name', $user->email) }}">
                                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3"><button class="btn btn-primary btn-sm"
                                            type="submit">Simpan</button></div>
                                </form>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Pengaturan Password</p>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3">
                                        <label class="form-label" for="current_password"><strong>Password
                                                Sekarang</strong></label>
                                        <input class="form-control" type="password" id="current_password"
                                            placeholder="Password" name="current_password">
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                    </div>
                                    <div class="row">
                                        <div class="col-sm col-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="password"><strong>Password
                                                        Baru</strong></label>
                                                <input class="form-control" type="password" id="password"
                                                    placeholder="Password Baru" name="password">
                                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="col-sm col-12">
                                            <div class="mb-3"><label class="form-label"
                                                    for="password_confirmation"><strong>Konfirmasi
                                                        Password</strong></label>
                                                <input class="form-control" type="password" id="password_confirmation"
                                                    placeholder="Konfirmasi Password" name="password_confirmation">
                                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3"><button class="btn btn-primary btn-sm"
                                            type="submit">Simpan</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
