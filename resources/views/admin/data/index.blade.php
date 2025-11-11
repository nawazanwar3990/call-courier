<x-dashboard-layout :page-title="$pageTitle">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <form method="GET" action="{{ route('admin.data.index') }}">
                        <input type="hidden" value="true" name="s">
                        <div class="row">
                            <div class="col-md-5">
                                {{ html()->select('bId', \App\Services\GeneralService::pluckBranches() ?? [], request('bId'))
                                    ->id('bId')
                                    ->placeholder('Select Branch')
                                    ->class('form-select')
                                    ->required() }}
                            </div>
                            <div class="col-md-5">
                                {{ html()->date('date')->id('date')->class('form-control')->value(request('date'))->required() }}
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    Fetch
                                </button>
                                @if($s AND isset($data) && count($data))
                                    <button class="btn btn-primary ms-2" id="downloadBtn">
                                        Save As Excel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                @if(isset($data) && count($data))
                    <div class="card-body">
                        <div id="branchData">
                            <table class="table table-bordered" id="dataTable">
                                <tr>
                                    <th>User</th>
                                    <th>CN No</th>
                                    <th>Created At</th>
                                </tr>
                                <tbody>
                                @foreach($data as $d)
                                    <tr>
                                        <td>{{ $d->user->username }}</td>
                                        <td>{{ $d->cn_no }}</td>
                                        <td>{{ $d->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <script>
        document.getElementById('downloadBtn').addEventListener('click', function(e){
            e.preventDefault(); // prevent form submission

            let table = document.getElementById('dataTable');
            if(!table) return;

            let rows = Array.from(table.querySelectorAll('tr'));
            let csv = rows.map(row => {
                let cols = Array.from(row.querySelectorAll('th,td'));
                let cnCol = cols[2]; // CN No column
                if(!cnCol) return '';
                return `"${cnCol.innerText.replace(/"/g, '""')}"`;
            }).join('\n');

            let blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            let link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `cn_no_export_{{ date('Y-m-d_H-i') }}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</x-dashboard-layout>
