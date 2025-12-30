@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@section('content')
    <div class="container-main">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="mb-2">
                <i class="fas fa-users"></i> Kelola User
            </h1>
            <p class="text-muted">Kelola daftar user dan hak akses</p>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Users Table -->
        @if($users->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Portfolio</th>
                                <th>Status</th>
                                <th>Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td>
                                        <code style="font-size: 0.85rem;">{{ $user->email }}</code>
                                    </td>
                                    <td>
                                        @{{ $user->username ?? 'user' . $user->id }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $user->portfolios_count }}</span>
                                    </td>
                                    <td>
                                        @if($user->is_banned)
                                            <span class="badge bg-danger">Diblokir</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.toggleBan', $user) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn {{ $user->is_banned ? 'btn-success' : 'btn-danger' }}" title="{{ $user->is_banned ? 'Aktifkan' : 'Blokir' }}">
                                                    <i class="fas {{ $user->is_banned ? 'fa-check' : 'fa-ban' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p class="mt-3">Belum ada user</p>
            </div>
        @endif
    </div>
@endsection
