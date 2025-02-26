@extends('layouts.master')
@section('title', 'Create Movie')
@section('content')
<form class="form-horizontal" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST" action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
    <input type="hidden" name="_method" value="POST">
<main class="main">
<div class="container-fluid">
    <div class="row">
        <!-- main title -->
        <div class="col-12">
            <div class="main__title">
                <h2>Add new item</h2>
            </div>
        </div>
        <!-- end main title -->
        <!-- form -->
        <div class="col-12">
            <form action="#" class="form">
                <div class="row">
                    <div class="col-12 col-md-5 form__cover">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-12">
                                <div class="form__img">
                                    <label for="form__img-upload">Upload cover (190 x 270)</label>
                                    <input id="form__img-upload" name="image" type="file"
                                        accept=".png, .jpg, .jpeg" />
                                    <img id="form__img" src="#" alt=" " />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 form__content">
                        <div class="row">
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input" name="title" id="title" placeholder="Title" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__group">
                                    <textarea id="text" name="text" class="form__textarea" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <input type="text" class="form__input" id="year" name="year" placeholder="Release year" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <input type="text" class="form__input" id="time" name="time" placeholder="Running timed in minutes" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <select class="js-example-basic-single" id="quality" name="quality">
                                        <option value="FullHD">FullHD</option>
                                        <option value="HD">HD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <input type="text" class="form__input" placeholder="Age" />
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <select class="js-example-basic-multiple" id="country" name="country[]" multiple="multiple">
                                        @foreach ($params['countries'] as $country)
                                        <option value="{{$country['id']}}">{{$country['title']}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <select class="js-example-basic-multiple" id="genre" name="genre[]" multiple="multiple">
                                        @foreach ($params['genres'] as $genre)
                                        <option value="{{$genre['id']}}">{{$genre['title']}}</option>    
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__gallery">
                                    <label id="gallery1" for="form__gallery-upload">Upload photos</label>
                                    <input data-name="#gallery1" id="form__gallery-upload" name="image" class="form__gallery-upload" type="file" accept=".png, .jpg, .jpeg" multiple />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <ul class="form__radio">
                            <li>
                                <span>Item type:</span>
                            </li>
                            <li>
                                <input id="type1" type="radio" name="type" value="movies" checked="" />
                                <label for="type1">Movie</label>
                            </li>
                            <li>
                                <input id="type2" type="radio" name="type" value="tv-show"/>
                                <label for="type2">TV Show</label>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="form__btn">publish</button>
                    </div>
                        {{-- <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form__video">
                                        <label id="movie1" for="form__video-upload">Upload video</label>
                                        <input data-name="#movie1" id="form__video-upload" name="movie"
                                            class="form__video-upload" type="file"
                                            accept="video/mp4,video/x-m4v,video/*" />
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form__group form__group--link">
                                        <input type="text" class="form__input" placeholder="or add a link" />
                                    </div>
                                </div>
                                
                            </div>
                        </div> --}}
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
                    // setTimeout(() => {
                    //     location.reload();
                    // }, "1000");
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
