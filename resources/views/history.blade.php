@extends('master')  

@section('title', 'سجل البيان الجمركي')  

@section('content')  
<div class="main-content">
    <div class="container mt-5">

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-success">سجل البيان الجمركي: <strong>{{ $declaration->declaration_number }}</strong></h1>
        </div>

        <!-- Card for Declaration Details -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">تفاصيل السجل</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-secondary mb-4">
                    <strong>الحالة الحالية:</strong> <span class="text-success">{{ $declaration->status }}</span>

                </div>

                <!-- History Table -->
                <table class="table table-bordered table-striped">
                    <thead class="table-success">
                        <tr>
                            <th>العملية</th>
                            <th>التاريخ والوقت</th>
                            <th>تم التغيير بواسطة</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $entry)
                            <tr>
                                <td>{{ $entry->action }}</td>
                                <td class="date-time">
                                    {{ \Carbon\Carbon::parse($entry->created_at)->translatedFormat('l، j F Y، الساعة h:i A') }}
                                </td>
                                <td>{{ $entry->user ? $entry->user->name : 'غير معروف' }}</td> <!-- Show user name if exists -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">لا توجد سجلات لعرضها</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
