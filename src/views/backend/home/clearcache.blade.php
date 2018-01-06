@extends("layouts.backend.layout")
@section("title","后台中心")

@push('css')
@endpush

@push('script')
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-header">
        <h4 class="data-title">清理缓存</h4>
    </div>
    <div class="data">
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">清理类型</label>
                <div class="col-xs-9 col-md-3 col-lg-3">
                    <div class="permission">
                        <div class="permission-label checkbox-inline">
                            <label>
                                <input class="checkbox-control" data-target="input.cache" type="checkbox" /> 全部清理
                            </label>
                        </div>
                        <div class="permission-list">
                            <div class="checkbox">
                                <label>
                                    <input name="clean[]" class="cache" type="checkbox" value="config" /> 清理配置缓存
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="clean[]" class="cache" type="checkbox" value="template" /> 清理模板缓存
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="clean[]" class="cache" type="checkbox" value="data" /> 清理数据缓存
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3 col-md-2 col-lg-2"></label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <button type="submit" class="btn btn-primary btn-sm">提交</button>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
</div>
@endsection