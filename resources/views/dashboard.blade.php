@extends('master')

@section('title', 'الصفحة الرئيسية')

@section('content')
<div class="main-content">
    <div class="container mt-5">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Header Section -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-4">
            <h1 class="text-center text-sm-start">البيانات الجمركية</h1>
            <button class="btn btn-success mt-3 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addDeclarationModal">إضافة بيان جديد</button>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>رقم البيان الجمركي</th>
                        <th>الحالة الحالية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($declarations as $declaration)
                    <tr>
                        <td>{{ $declaration->declaration_number }}</td>
                        <td>{{ $declaration->status }}</td>
                        <td>
                            <a href="{{ route('declaration.showHistory', $declaration->id) }}" class="btn btn-warning text-white">
                                <i class="bi bi-clock"></i>  
                            </a>
                            <button class="btn btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#editStatusModal"
                                data-id="{{ $declaration->id }}"
                                data-status="{{ $declaration->status }}">
                                <i class="bi bi-pencil"></i>  
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <div class="pagination-container">
                {{ $declarations->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Add Declaration Modal -->
        <div class="modal fade" id="addDeclarationModal" tabindex="-1" role="dialog" aria-labelledby="addDeclarationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDeclarationModalLabel">إضافة بيان جمركي جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('declaration.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="declaration_number">رقم البيان الجمركي</label>
                                <input type="text" id="declaration_number" name="declaration_number" class="form-control" placeholder="أدخل رقم البيان الجمركي" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">الحالة</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="العقبة">العقبة</option>
                                    <option value="عمان">عمان</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">إضافة البيان</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Status Modal -->
        <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusModalLabel">تعديل الحالة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('declaration.updateStatus', ':id') }}" method="POST" id="updateStatusForm">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group mb-3">
                                <label for="edit-status">الحالة</label>
                                <select name="status" id="edit-status" class="form-control" required>
                                    <option value="العقبة">العقبة</option>
                                    <option value="عمان">عمان</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">تعديل الحالة</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close success alert after 3 seconds
        setTimeout(function() {
            $('#success-alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);

        // Set data to Edit Modal
        $('#editStatusModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var declarationId = button.data('id');
            var declarationStatus = button.data('status');
            var actionUrl = "{{ route('declaration.updateStatus', ':id') }}";
            actionUrl = actionUrl.replace(':id', declarationId);

            $('#updateStatusForm').attr('action', actionUrl);
            $('#edit-status').val(declarationStatus);
        });
    });
</script>

@endsection
