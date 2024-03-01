@section('title', 'Profil')

<x-app-layout>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Profile</h3>
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body text-center shadow">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show"
                                role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @error('avatar')
                            <div class="alert alert-danger alert-dismissible fade show"
                                role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror

                        <img class="rounded-circle mb-3 mt-4"
                            src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('assets/img/default.jpg') }}"
                            width="160" height="160"
                            style="object-fit:cover">
                        <div class="mb-3">
                            <form method="POST"
                                action="{{ route('profile.store') }}"
                                enctype="multipart/form-data" id="avatarForm">
                                @csrf
                                <label for="avatar">
                                    <a
                                        class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="icon text-white-50"><i
                                                class="fas fa-sync-alt"></i></span>
                                        <span class="text">Ganti Foto</span>
                                    </a>
                                </label>
                                <input type="file" id="avatar"
                                    name="avatar" class="d-none">
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card bg-primary text-light mb-4 shadow">
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
                        <div class="card mb-3 shadow">
                            <div class="card-header py-3">
                                <p class="text-primary fw-bold m-0">Pengaturan
                                    Pengguna</p>
                            </div>
                            <div class="card-body">
                                <form id="send-verification" method="post"
                                    action="{{ route('verification.send') }}">
                                    @csrf
                                </form>

                                <form method="post"
                                    action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')
                                    @if (session('status') === 'profile-updated')
                                        <div class="alert alert-success alert-dismissible fade show"
                                            role="alert">
                                            <strong>Profil berhasil
                                                diperbarui!</strong>
                                            <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm col-12">
                                            <div class="mb-3"><label
                                                    class="form-label"
                                                    for="name"><strong>Nama</strong></label><input
                                                    class="form-control"
                                                    type="text"
                                                    id="name"
                                                    placeholder="Nama Pengguna"
                                                    name="name"
                                                    value="{{ old('name', $user->name) }}">
                                                <x-profile.input-error
                                                    class="mt-2"
                                                    :messages="$errors->get(
                                                        'name',
                                                    )" />
                                            </div>
                                        </div>
                                        <div class="col-sm col-12">
                                            <div class="mb-3"><label
                                                    class="form-label"
                                                    for="email"><strong>Email</strong></label><input
                                                    class="form-control"
                                                    type="email"
                                                    id="email"
                                                    placeholder="Email Pengguna"
                                                    name="email"
                                                    value="{{ old('name', $user->email) }}">
                                                <x-profile.input-error
                                                    class="mt-2"
                                                    :messages="$errors->get(
                                                        'email',
                                                    )" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button
                                            class="btn btn-primary btn-sm btn-icon-split"
                                            type="submit">
                                            <span class="icon text-white-50"><i
                                                    class="fas fa-save"></i></span>
                                            <span class="text">Simpan</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary fw-bold m-0">Pengaturan
                                    Password</p>
                            </div>
                            <div class="card-body">
                                <form method="post"
                                    action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')
                                    @if (session('status') === 'password-updated')
                                        <div class="alert alert-success alert-dismissible fade show"
                                            role="alert">
                                            <strong>Password berhasil
                                                diperbarui!</strong>
                                            <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="current_password"><strong>Password
                                                Sekarang</strong></label>
                                        <input class="form-control"
                                            type="password"
                                            id="current_password"
                                            placeholder="Password"
                                            name="current_password">
                                        <x-profile.input-error :messages="$errors->updatePassword->get(
                                            'current_password',
                                        )"
                                            class="mt-2" />
                                    </div>
                                    <div class="row">
                                        <div class="col-sm col-12">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="password"><strong>Password
                                                        Baru</strong></label>
                                                <input class="form-control"
                                                    type="password"
                                                    id="password"
                                                    placeholder="Password Baru"
                                                    name="password">
                                                <x-profile.input-error
                                                    :messages="$errors->updatePassword->get(
                                                        'password',
                                                    )"
                                                    class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="col-sm col-12">
                                            <div class="mb-3"><label
                                                    class="form-label"
                                                    for="password_confirmation"><strong>Konfirmasi
                                                        Password</strong></label>
                                                <input class="form-control"
                                                    type="password"
                                                    id="password_confirmation"
                                                    placeholder="Konfirmasi Password"
                                                    name="password_confirmation">
                                                <x-profile.input-error
                                                    :messages="$errors->updatePassword->get(
                                                        'password_confirmation',
                                                    )"
                                                    class="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button
                                            class="btn btn-primary btn-sm btn-icon-split"
                                            type="submit">
                                            <span class="icon text-white-50"><i
                                                    class="fas fa-save"></i></span>
                                            <span class="text">Simpan</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#avatar').change(function() {
                $('#avatarForm').submit();
            });
        </script>
    @endpush
</x-app-layout>
