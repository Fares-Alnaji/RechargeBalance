@extends('cms.parent')

@section('title', '')

@section('css_content')
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Transformation to Merchants</h3>
                            <br>
                            <h3 class="card-title">balance: {{ auth()->user()->balance }}$</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Merchants</label>
                                    <select class="form-control" id="merchant_id">
                                        <option disabled selected>Choose Merchants</option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category_title">amount:</label>
                                    <input type="text" class="form-control" id="amount" placeholder="amount">
                                </div>
                                <div class="form-group">
                                    <label for="category_title">deduction %:</label>
                                    <input type="number" class="form-control" id="deduction" placeholder="deduction %">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="saveCategory()" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_content')
    <script>
        function saveCategory() {
            axios.post('/cms/admin/transfer', {
                    merchant_id: document.getElementById('merchant_id').value,
                    amount: document.getElementById('amount').value,
                    deduction: document.getElementById('deduction').value,
                }).then(function(response) {
                    showMessage(response.data.icon, response.data.message);
                })
                .catch(function(error) {
                    showMessage(error.response.data.icon, error.response.data.message);
                });
        }

        function showMessage(icon, message) {
            Swal.fire({
                position: 'center',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
