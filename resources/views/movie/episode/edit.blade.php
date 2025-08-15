@extends('layouts.master')
@section('title', 'Update episode')
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
                <h2>Update episode</h2>
            </div>
        </div>
        <!-- end main title -->
        <!-- form -->
        <div class="col-12">
            <form class="form-horizontal" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
            enctype="multipart/form-data" method="POST" action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="{{$params['id']}}">
                <!-- Server Block Container -->
                <div id="server-container">
                    <!-- Server -->
                    @php
                        $totalServer = 0
                    @endphp
                    @foreach ($params['server']['server'] as $index => $server)
                        {{$totalServer++}}
                        <div class="server-block" data-server-index={{$index}}>
                        <button type="button" class="form__btn remove-server">Remove Server</button>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <div class="form__group">
                                    <label>Server</label>
                                    <select class="js-example-basic-single form__input" name="server[{{$index}}][server_id]">
                                        @foreach ($params['servers'] as $s)
                                        <option value="{{$s['id']}}" 
                                        {{$s['id'] == $server['server_id'] ? 'selected' : ''}}>
                                        {{$s['name']}}
                                        </option>     
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12"></div>
                            @foreach ($server['episodes']['episode'] as $epIndex => $episode)  
                            <div class="episode-group row" data-episode-index="{{$epIndex}}">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="form__group">
                                        <label>Episode</label>
                                        <select class="js-example-basic-single episode-select form__input" name="server[{{$index}}][episodes][episode][]">
                                            @if ($params['movie']['episode_total'] == 1)
                                            <option value="FHD" {{ $episode == 'FHD' ? 'selected' : '' }}>Full HD</option>
                                            <option value="HD" {{ $episode == 'HD' ? 'selected' : '' }}>HD</option>
                                            @else
                                                @for ($i = 1; $i <= $params['movie']['episode_total']; $i++)
                                                    <option value="{{ $i }}" {{ $i == $episode ? 'selected' : '' }}>Ep {{ $i }}</option>
                                                @endfor
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form__group">
                                        <label>Link</label>
                                        <input type="text" class="form__input" name="server[{{ $index }}][episodes][hls][]" placeholder="Link url" value="{{$server['episodes']['hls'][$epIndex]}}" />
                                    </div>
                                </div>
                                <div class="col-1">
                                <label></label>
                                @if ($epIndex == 0)
                                    <button type="button" class="form__btn" id="add-episode-{{ $index }}">Add Episode</button>
                                @else
                                    <button type="button" class="form__btn remove-episode">X</button>
                                @endif
                            </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                   
                </div>
                <div class="col-12">
                    <button style="margin-bottom: 1%;" type="button" class="form__btn" id="add-server">Add Server</button>
                    <button type="submit" class="form__btn">Publish</button>
                </div>
            </form>
        </div>
        <!-- end form -->
    </div>
</div>
</main>
<script>
    $(document).ready(function() {
         // Dữ liệu mẫu từ PHP (giả lập $params['movie']['episode_total'])
        const episodeTotal = "{{ $params['movie']['episode_total'] }}"; // Số tập tối đa, thay bằng {{ $params['movie']['episode_total'] }} trong Blade

        let episodeOptions = '';
        let serverCount = "{{$totalServer}}"; 
        
        // Hàm tạo options cho episode
        function loadEpisodes(count) {
            episodeOptions = '';
            if (count == 1) {
                episodeOptions += `<option value="FHD">Full HD</option><option value="HD">HD</option>`;
            } else {
                for (let i = 1; i <= parseInt(count); i++) {
                    episodeOptions += `<option value="${i}">Ep ${i}</option>`;
                }
            }
            $('.episode-select').each(function() {
                if ($(this).children('option').length === 0) {
                    $(this).html(episodeOptions);
                }
            });
            $('.js-example-basic-single').select2(); // Khởi tạo Select bảo vệ
        }

        // Gọi hàm loadEpisodes khi trang tải
        loadEpisodes(episodeTotal);

        // Xử lý thêm Episode
        $(document).on('click', '[id^=add-episode-]', function() {
            const serverIndex = $(this).closest('.server-block').data('server-index');
            const episodeGroup = `
                <div class="episode-group row" data-episode-index="${$(this).closest('.server-block').find('.episode-group').length}">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="form__group">
                            <label>Episode</label>
                            <select class="js-example-basic-single episode-select form__input" name="server[${serverIndex}][episodes][episode][]">
                                ${episodeOptions}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form__group">
                            <label>Link</label>
                            <input type="text" class="form__input" name="server[${serverIndex}][episodes][hls][]" placeholder="Link url" value="" />
                        </div>
                    </div>
                    <div class="col-1">
                        <label></label>
                        <button type="button" class="form__btn remove-episode">X</button>
                    </div>
                </div>`;
            $(this).closest('.episode-group').after(episodeGroup);
            $('.js-example-basic-single').select2(); // Khởi tạo Select2 cho select mới
        });

        // Xử lý xóa Episode
        $(document).on('click', '.remove-episode', function() {
            $(this).closest('.episode-group').remove();
        });

        // Xử lý thêm Server
        $('#add-server').on('click', function() {
            const newServerIndex = serverCount++;
            const serverBlock = `
                <div class="server-block" data-server-index="${newServerIndex}">
                    <button type="button" class="form__btn remove-server">Remove Server</button>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <div class="form__group">
                                <label>Server</label>
                                <select class="js-example-basic-single form__input" name="server[${newServerIndex}][server_id]">
                                    @foreach ($params['servers'] as $s)
                                    <option value="{{$s['id']}}">{{$s['name']}}</option>     
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12"></div>
                        <div class="episode-group row" data-episode-index="0">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <label>Episode</label>
                                    <select class="js-example-basic-single episode-select form__input" name="server[${newServerIndex}][episodes][episode][]">
                                        ${episodeOptions}
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form__group">
                                    <label>Link</label>
                                    <input type="text" class="form__input" name="server[${newServerIndex}][episodes][hls][]" placeholder="Link url" value="" />
                                </div>
                            </div>
                            <div class="col-1">
                                <label></label>
                                <button type="button" class="form__btn" id="add-episode-${newServerIndex}">Add Episode</button>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('#server-container').append(serverBlock);
            $('.js-example-basic-single').select2(); // Khởi tạo Select2 cho select mới
        });

        // Xử lý xóa Server
        $(document).on('click', '.remove-server', function() {
            if ($('.server-block').length > 1) {
                $(this).closest('.server-block').remove();
            } else {
                alert('At least one server is required.');
            }
        });

        $('#admin-{{ $params["prefix"] }}-form').submit(function(e) {
            
            // showLoadding();
            // $('.input-error').html('');
            // $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
            $('.spinner').show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['episode' => $params['id']]) }}",
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
                    $('.spinner').hide();
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
        // $('#movie').change(function(){
        //     const movieId = $(this).val();
        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.get-episode') }}",
        //         data: {
        //             movie_id: movieId
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             $('#episode').empty();
        //             loadEpisodes(response.data);
        //         }
        //     });
        // })
        $(document).on('click', '.remove-episode', function() {
            $(this).closest('.col-1').prev().remove(); 
            $(this).closest('.col-1').prev().remove(); 
            $(this).closest('.col-1').remove();     
        });
    });
</script>
@stop
