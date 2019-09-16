<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">曲目列表</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped">

                @foreach($lists as $list)
                <tr>
                    <td width="120px">{{ $list['platform'] }}</td>
                    <td>{{ $list['project_name'] }}</td>
                    <td><span class="label label-primary">{{ $list['amount'] }}</span></td>

                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
</div>