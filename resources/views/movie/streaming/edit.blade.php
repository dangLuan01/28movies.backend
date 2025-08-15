@extends('layouts.master')
@section('title', 'Update Streaming')
@section('content')
<style>
    label{
        color: #fff;
    }
</style>
<form class="form-horizontal" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
    enctype="multipart/form-data" method="POST" action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['streaming'=>$params['id']]) }}">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="{{$params['item']['id']}}">
<main class="main">
<div class="container-fluid">
    <div class="row">
        <!-- main title -->
        <div class="col-12">
            <div class="main__title">
                <h2>Update item</h2>
            </div>
        </div>
        <!-- end main title -->
        <!-- form -->
        <div class="col-12">
            <form action="#" class="form">
                <div class="row">
                    <div class="col-12 col-md-7 form__content">
                      <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <label>Name</label>
                                    <input type="text" class="form__input slug" name="name" id="name" placeholder="Enter name . . ." value="{{ $params['item']['name'] }}" required/>
                                </div>
                            </div>   
                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <label>Status</label>
                                    <select class="js-example-basic-single select2" id="status" name="status">
                                        <option value="0" >Hidden</option>
                                        <option value="1" selected>Active</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <label>Id</label>
                                    <input type="text" class="form__input" value="{{ $params['item']['url'] }}" disabled/>
                                </div>
                            </div>                 
                           <div class="col-12">
                                <div class="form__gallery">
                                    <label id="gallery1" for="form__gallery-upload">Upload file</label>
                                    <input data-name="#gallery1" id="form__gallery-upload" name="hls" class="form__gallery-upload" type="file" accept=".m3u8" />
                                    <input type="hidden" name="idHls" value="{{ $params['item']['url'] }}">
                                </div>
                            </div>                          
                        </div>
                    </div>
                   
                    <div class="col-12">
                        <button type="submit" class="form__btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- end form -->
    </div>
</div>
</main>
</form>
<script>
    $(document).ready(function() {
        $('#admin-{{ $params["prefix"] }}-form').submit(function(e) {
            $('.spinner').show();
            // $('.input-error').html('');
            // $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update',['streaming' => $params['item']['id']]) }}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    // toastr.success(data.message);
                    $('.spinner').hide();
                    setTimeout(() => {
                        location.reload();
                    }, "500");
                },
                error: function(data) {
                    $('.spinner').hide();
                    // hideLoadding();

                    // for (x in data.responseJSON.errors) {
                    //     $('#' + x).parents('.form-group').find('.input-error').html(data
                    //         .responseJSON.errors[x]);
                    //     $('#' + x).parents('.form-group').find('.input-error').show();
                    //     $('#' + x).addClass('is-invalid');
                    // }
                }
            });
        });

    });
</script>
@stop
