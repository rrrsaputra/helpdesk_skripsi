@extends('layouts.admin')
@section('header')
    <x-admin.header title="User Feedback" />
@endsection

@section('content')
    @php
        $columns = ['Category', 'User Name', 'Subject', 'Message', 'Attachments', 'Date'];
        $data = $feedbacks
            ->map(function ($feedback) {
                return [
                    'id' => $feedback->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $feedback->category,
                        $feedback->user->name,
                        $feedback->subject,
                        strip_tags($feedback->message),
                        $feedback->attachments->isNotEmpty()
                            ? '<span class="attachment-link" data-id="' .
                                $feedback->id .
                                '" onmouseover="this.style.cursor=\'pointer\'"><i class="fas fa-paperclip"></i> View Attachments</span>'
                            : '',
                        $feedback->created_at->format('d M Y'),
                    ],
                ];
            })
            ->toArray();
        $columnSizes = array_map(function ($column) {
            return $column === 'Message' ? '40%' : 'auto';
        }, $columns);
    @endphp

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">

    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('admin.feedback.index') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="search" class="form-control" id="search" name="search"
                                    style="width: 500px;" placeholder="Search by category, subject, and message">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach ($columns as $index => $column)
                                        <th style="width: {{ $columnSizes[$index] ?? 'auto' }}">{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr style="cursor: pointer" data-id="{{ $row['id'] }}"
                                        onclick="showMessagePopup('{{ addslashes($row['values'][3]) }}')">
                                        @foreach ($row['values'] as $value)
                                            <td>
                                                @if (is_array($value))
                                                    @foreach ($value as $index => $subValue)
                                                        <div>
                                                            @php
                                                                $charLimit =
                                                                    isset($columnSizes[$index]) &&
                                                                    is_numeric($columnSizes[$index])
                                                                        ? intval($columnSizes[$index] * 0.5)
                                                                        : 70;
                                                            @endphp
                                                            @if ($index === 0)
                                                                <strong>{!! strlen($subValue) > $charLimit ? substr($subValue, 0, $charLimit) . '...' : $subValue !!}</strong>
                                                            @else
                                                                {!! strlen($subValue) > $charLimit ? substr($subValue, 0, $charLimit) . '...' : $subValue !!}
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    {!! $value !!}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    <!-- Attachments Container -->
                                    <div id="attachments-{{ $row['id'] }}" style="display: none;">
                                        @foreach ($feedbacks->find($row['id'])->attachments as $attachment)
                                            <div class="attachment-item">
                                                @if (strpos($attachment->path, '.jpg') !== false ||
                                                        strpos($attachment->path, '.jpeg') !== false ||
                                                        strpos($attachment->path, '.png') !== false ||
                                                        strpos($attachment->path, '.gif') !== false)
                                                    <img src="{{ asset('storage/' . $attachment->path) }}"
                                                        alt="{{ $attachment->name }}"
                                                        style="max-width: 100%; height: auto;">
                                                @else
                                                    <a href="{{ asset('storage/' . $attachment->path) }}"
                                                        target="_blank">{{ $attachment->name }}</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8">No feedbacks found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showMessagePopup(message) {
            const modalId = 'feedbackMessageModal-' + new Date().getTime();
            const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" role="dialog" aria-labelledby="${modalId}-label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="${modalId}-label">Feedback Message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            $('#' + modalId).modal('show');

            $('#' + modalId).on('hidden.bs.modal', function() {
                document.getElementById(modalId).remove();
            });
        }

        function showAttachmentsModal(feedbackId) {
            const attachmentsContainer = document.getElementById('attachments-' + feedbackId);
            const modalId = 'attachmentsModal-' + feedbackId;
            const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" role="dialog" aria-labelledby="${modalId}-label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="${modalId}-label">Attachments</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ${attachmentsContainer.innerHTML}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            $('#' + modalId).modal('show');

            $('#' + modalId).on('hidden.bs.modal', function() {
                document.getElementById(modalId).remove();
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.attachment-link').forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const feedbackId = event.target.getAttribute('data-id');
                    showAttachmentsModal(feedbackId);
                });
            });
        });
    </script>

    <!-- DataTables & Plugins -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
