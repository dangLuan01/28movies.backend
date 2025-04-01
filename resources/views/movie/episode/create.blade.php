@extends('layouts.master')
@section('title', 'Create Movie')
@section('content')
<style>
    label{
        color: #fff;
    }
</style>

<main class="main">
<div class="container-fluid">
    <div class="row">
        <!-- main title -->
        <div class="col-12">
            <div class="main__title">
                <h2>Add new episode</h2>
            </div>
        </div>
        <!-- end main title -->
        <!-- form -->
        <div class="col-12">
            <form class="form-horizontal" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
            enctype="multipart/form-data" method="POST" action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
                <input type="hidden" name="_method" value="POST">
                <div class="row">
                    <div class="col-12 col-md-7 form__content">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <label>Movie</label>
                                <div class="form__group">
                                    <select class="js-example-basic-multiple" id="movie" name="movie_id" >
                                        <option value="">Choose movie</option>
                                        @foreach ($params['movie'] as $movie)
                                            <option value="{{ $movie['id'] }}">{{ $movie['name'] }}</option>
                                        @endforeach                                           
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="form__group">
                            <label>Episode</label>
                            <select class="js-example-basic-single" id="episode" name="episode[]">
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form__group">
                            <label>Link</label>
                            <input type="text" class="form__input" id="hls" name="hls[]" placeholder="Link url" value="" />
                        </div>
                    </div>
                    <div class="col-1">
                        <label></label>
                        <button type="button" class="form__btn" id="add-episode">Add</button>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="form__btn">publish</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- end form -->
    </div>
</div>
</main>
<script>
    $(document).ready(function() {
        $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {
            
            // showLoadding();
            // $('.input-error').html('');
            // $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    // hideLoadding();
                    // toastr.success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, "1000");
                },
                error: function(data) {
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
