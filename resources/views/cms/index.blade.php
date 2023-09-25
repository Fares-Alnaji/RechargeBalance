@extends('cms.parent')

@section('title', 'transaction')

@section('css_content')
    <link rel="stylesheet" href="{{ asset('cms/css/style.css') }}">
@endsection

@section('content')
    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <label for="startDate"> Merchant name:</label>
                    <select id="merchantFilterSelect" class="form-control">
                        <option value="">All Merchants</option>
                        @foreach ($Merchants as $Merchant)
                            <option value="{{ $Merchant->name }}">{{ $Merchant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="startDate">Start Date:</label>
                        <input type="date" id="startDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="endDate">Expiry date:</label>
                        <input type="date" id="endDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 32px">
                    <button id="filterButton" class="btn btn-primary">filtering</button>
                </div>

                <div class="col-md-5">
                    <select id="filterType" class="form-control">
                        <option value="all">All</option>
                        <option value="greater">bigger</option>
                        <option value="smaller">Younger than</option>
                        <option value="equal">Equal to</option>
                    </select>
                </div>
                <!-- حقل إدخال لقيمة الفلتر -->
                <div class="col-md-5">
                    <input type="number" id="filterAmount" class="form-control" placeholder="filtering">
                </div>
                <!-- زر تنفيذ البحث -->
                <div class="col-md-2">
                    <button id="applyFilter" class="btn btn-primary">filtering</button>
                </div>
            </div>

            {{-- <div class="col-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Merchant Name">
            </div> --}}

            <br>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Responsive Hover Table</h3>

                            <div class="card-tools">
                                    <div class="input-group-append">
                                        <div>
                                            <a href="{{route('export')}}" id="applyFilter" class="btn btn-primary">Export <i class="fas fa-file-download"></i></a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Merchant name</th>
                                        <th>Merchant account number</th>
                                        <th>Amount before discount</th>
                                        <th>Amount after discount</th>
                                        <th>The amount of fixed deductions</th>
                                        <th>The amount of deduction entered</th>
                                        <th>Wallet balance before the transaction(merchant)</th>
                                        <th>Wallet balance after the transaction(merchant)</th>
                                        <th>Wallet balance before the transaction(admin)</th>
                                        <th>Wallet balance after the transaction(admin)</th>
                                        <th>Process code</th>
                                        <th>Transfer date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Transactions as $Transaction)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $Transaction->merchant->name }}</td>
                                            <td>{{ $Transaction->merchant->account_number }}</td>
                                            <td>{{ $Transaction->amount }}</td>
                                            <td>{{ $Transaction->amount - $Transaction->deduction - '1.5' }}</td>
                                            <td> 1.5% </td>
                                            <td>{{ $Transaction->deduction }}</td>
                                            <td>{{ $Transaction->merchant_balance_before }}</td>
                                            <td>{{ $Transaction->merchant_balance_after }}</td>
                                            <td>{{ $Transaction->admin->balance + $Transaction->amount }}</td>
                                            <td>{{ $Transaction->admin->balance }}</td>
                                            <td>{{ rand(0, 99999) }}</td>
                                            <td>{{ $Transaction->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    @foreach ($Transactions->links()->elements[0] as $page)
                                    <li class="page-item"><a class="page-link" href="{{$page}}">{{$loop->index + 1}}</a></li>
                                    @endforeach
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_content')
    <script>
        $(document).ready(function() {
            $("#merchantFilterSelect").on("change", function() {
                var selectedMerchantId = $(this).val();

                $("table tbody tr").each(function() {
                    var merchantName = $(this).find("td:eq(1)").text();

                    if (selectedMerchantId === "" || merchantName === selectedMerchantId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script>
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const filterButton = document.getElementById('filterButton');

        filterButton.addEventListener('click', () => {

            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(23, 59, 59, 999);
            const tableRows = document.querySelectorAll('.table tbody tr');

            tableRows.forEach(row => {
                const transactionDate = new Date(row.querySelector('td:nth-child(13)')
                    .textContent);
                if (transactionDate >= startDate && transactionDate <
                    endDate) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

<script>
    document.getElementById('applyFilter').addEventListener('click', () => {
        // الحصول على قيمة نوع الفلتر والقيمة المدخلة
        const filterType = document.getElementById('filterType').value;
        const filterAmount = parseFloat(document.getElementById('filterAmount').value);

        // الحصول على صفوف الجدول
        const tableRows = document.querySelectorAll('.table tbody tr');

        tableRows.forEach(row => {
            const amount = parseFloat(row.querySelector('td:nth-child(4)').textContent); // استبدل الرقم بالمؤشر الخاص بعمود المبلغ

            if (filterType === 'all' ||
                (filterType === 'greater' && amount > filterAmount) ||
                (filterType === 'smaller' && amount < filterAmount) ||
                (filterType === 'equal' && amount === filterAmount)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
