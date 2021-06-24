@extends('index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal payment-calculate-form">
            <div class="row">
                <div class="notifications">
                    <div class="alert alert-success hidden" role="alert"></div>
                    <div class="alert alert-warning hidden" role="alert"></div>
                    <div class="alert alert-danger hidden" role="alert"></div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">JSON Array</label>
                    <div class="col-sm-8 description">
                        <textarea class="form-control" rows="15" name="jsonArray" id="jsonArray" placeholder="Enter Json array"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="calculatePayment">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row payment-details">
            <div class="form-group">
                <label class="control-label col-sm-10 json-data" for="email">Result Here</label>
            </div>
        </div>
    </div>
</div>

@endsection




