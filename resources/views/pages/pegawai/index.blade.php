@extends('layouts.dashboard')

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <h3>Pegawai</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </button>
    </div>

    <table id="table-pegawai" class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">No HP</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $pegawai)
                <tr>
                    <td>
                        @if ($pegawai->avatar == null)
                            <span class="badge bg-danger">Tidak Ada Foto</span>
                        @else
                            <img class="img-thumbnail" src="{{ asset('storage/' . $pegawai->avatar) }}"
                                alt="{{ $pegawai->name }}" width="50">
                        @endif
                    </td>
                    <td>{{ $pegawai->name }}</td>
                    <td>{{ $pegawai->email }}</td>
                    <td>{{ $pegawai->phone_number }}</td>
                    <td>{{ $pegawai->alamat }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button onclick="openEditModal('{{ $pegawai->id }}')" type="button"
                                class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteUser('{{ $pegawai->id }}')" type="button" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="addName" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" id="addName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="addPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPhoneNumber" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="addPhoneNumber" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="addAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="addAlamat" rows="3" name="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addAvatar" class="form-label">Foto</label>
                            <input class="form-control" type="file" id="addAvatar" name="avatar">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button onclick="createUser()" type="button" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="editPhoneNumber" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="editPhoneNumber" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="editAlamat" rows="3" name="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editAvatar" class="form-label">Foto</label>
                            <input class="form-control" type="file" id="editAvatar" name="avatar">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button onclick="editUser()" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let userId = null;

        // Reset form, hapus class is-invalid dan invalid-feedback saat buka modal addModal
        $('#addModal').on('show.bs.modal', function(e) {
            $('#addForm').trigger('reset');
            $('#addForm input').removeClass('is-invalid');
            $('#addForm .invalid-feedback').remove();
        });

        // Reset form, hapus class is-invalid dan invalid-feedback saat buka modal editModal
        $('#editModal').on('show.bs.modal', function(e) {
            $('#editForm').trigger('reset');
            $('#editForm input').removeClass('is-invalid');
            $('#editForm .invalid-feedback').remove();
        });

        // Fungsi untuk membuat pegawai baru
        function createUser() {
            const url = "{{ route('api.pegawai.store') }}";

            let data = new FormData();
            data.append('name', $('#addName').val());
            data.append('email', $('#addEmail').val());
            data.append('phone_number', $('#addPhoneNumber').val());
            data.append('password', $('#addPassword').val());
            data.append('alamat', $('#addAlamat').val());
            data.append('avatar', $('#addAvatar').prop('files')[0]);

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message, 'Sukses');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(error) {
                    let response = error.responseJSON;
                    toastr.error(response.message, 'Error');
                    if (response.errors) {
                        for (const error in response.errors) {
                            let input = $(`#addForm input[name="${error}"]`);
                            input.addClass('is-invalid');
                            let feedbackElement = `<div class="invalid-feedback"><ul class="list-unstyled">`;
                            response.errors[error].forEach((message) => {
                                feedbackElement += `<li>${message}</li>`;
                            });
                            feedbackElement += `</ul></div>`;
                            input.after(feedbackElement);
                        }
                    }
                }
            });
        }

        // Fungsi untuk membuka modal edit dan mengisi data pegawai yang ada
        function openEditModal(id) {
            const url = `{{ route('api.pegawai.show', ':userId') }}`.replace(':userId', id);

            $.get(url, function(data) {
                $('#editName').val(data.name);
                $('#editEmail').val(data.email);
                $('#editPhoneNumber').val(data.phone_number);
                $('#editAlamat').val(data.alamat);
                userId = id;
                $('#editModal').modal('show');
            });
        }

        // Fungsi untuk mengedit pegawai yang ada
        function editUser() {
            const url = `{{ route('api.pegawai.update', ':userId') }}`.replace(':userId', userId);

            let data = new FormData();
            data.append('name', $('#editName').val());
            data.append('email', $('#editEmail').val());
            data.append('phone_number', $('#editPhoneNumber').val());
            if ($('#editPassword').val()) {
                data.append('password', $('#editPassword').val());
            }
            data.append('alamat', $('#editAlamat').val());
            if ($('#editAvatar').prop('files')[0]) {
                data.append('avatar', $('#editAvatar').prop('files')[0]);
            }
            data.append('_method', 'PUT'); // Tambahkan ini untuk memastikan metode PUT digunakan

            $.ajax({
                url: url,
                type: 'POST', // Menggunakan POST karena Laravel membutuhkan metode _method
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message, 'Sukses');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(error) {
                    let response = error.responseJSON;
                    toastr.error(response.message, 'Error');
                    if (response.errors) {
                        for (const error in response.errors) {
                            let input = $(`#editForm input[name="${error}"]`);
                            input.addClass('is-invalid');
                            let feedbackElement = `<div class="invalid-feedback"><ul class="list-unstyled">`;
                            response.errors[error].forEach((message) => {
                                feedbackElement += `<li>${message}</li>`;
                            });
                            feedbackElement += `</ul></div>`;
                            input.after(feedbackElement);
                        }
                    }
                }
            });
        }

        // Fungsi untuk menghapus pegawai
        function deleteUser(userId) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Pegawai akan dihapus, kamu tidak bisa mengembalikannya lagi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('api.pegawai.destroy', ':userId') }}";
                    url = url.replace(':userId', userId);

                    $.post(url, {
                            _method: 'DELETE'
                        })
                        .done((response) => {
                            toastr.success(response.message, 'Sukses');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        })
                        .fail((error) => {
                            toastr.error('Gagal menghapus pegawai', 'Error');
                        });
                }
            });
        }

        $(document).ready(function() {
            new DataTable('#table-pegawai');
        });
    </script>
@endpush
