
<!-- Start of Selection -->
@props(['articles'])

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')}}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')}}">

<div class="card">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @if(is_array($articles) || is_object($articles))
                    @foreach($articles as $article)
                    <tr style="cursor: pointer">
                      <td>{{ $article->title }}</td>
                      <td>{{ Str::limit($article->content, 50) }}</td>
                      <td>{{ $article->user->name }}</td>
                      <td></td>
                      <td>
                        <a href="{{ route('admin.article.edit', $article->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.article.destroy', $article->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    
                      </td>
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="5">No articles available</td>
                    </tr>
                  @endif
                </tbody>
              </table>
              {{ $articles->links() }}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </div>
<!-- End of Selection -->

  <!-- jQuery -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- DataTables & Plugins -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>

  <!-- Page specific script -->
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
          {
            extend: 'copy',
            text: '<i class="fas fa-copy"></i> Copy'
          },
          {
            extend: 'csv',
            text: '<i class="fas fa-file-csv"></i> CSV'
          },
          {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel'
          },
          {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF'
          },
          {
            extend: 'print',
            text: '<i class="fas fa-print"></i> Print'
          },
          {
            extend: 'colvis',
            text: '<i class="fas fa-columns"></i> Column visibility'
          }
        ]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": [
          {
            extend: 'copy',
            text: '<i class="fas fa-copy"></i> Copy'
          },
          {
            extend: 'csv',
            text: '<i class="fas fa-file-csv"></i> CSV'
          },
          {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel'
          },
          {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF'
          },
          {
            extend: 'print',
            text: '<i class="fas fa-print"></i> Print'
          },
          {
            extend: 'colvis',
            text: '<i class="fas fa-columns"></i> Column visibility'
          }
        ]
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  
      // Make the row clickable
      $('#example2 tbody').on('mouseover', 'tr', function () {
        $(this).css('cursor', 'pointer');
      });
    });
  </script>