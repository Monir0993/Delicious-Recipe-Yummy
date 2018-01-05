@extends('private.home.layout')

@section('formJS')
    <script>
        $('.detailsLink').click(function (e) {
            e.preventDefault();
            var i = Number($(this).attr('href'));
            $('#formDetails' + i).submit();
        });

        $('.favBtn').click(function (e) {
            e.preventDefault();
            var i = Number($(this).attr('href'));

            request = $.ajax({
                url: '../add-to-favorite',
                type: 'POST',
                data: $('#formFav' + i).serialize()
            });

            request.done(function (data, textStatus, jqXHR) {
                result = jQuery.parseJSON(data);
                if (result.isOK === true) {
                    $('#favLink' + i).html("<i class='fa fa-star'></i> Favourite");
                    $('#favLink' + i).css('background-color', 'rgb(250, 60, 76)');
                    $('#favLink' + i).css('border-color', 'rgb(250, 60, 76)');
                }
            });
        });
    </script>
@endsection

@section('content')
    @if(count($response['hits']))
        <?php $i = 1; ?>
        @foreach($response['hits'] as $food)

            <div style="display: none">
                {{ Form::open(['url' => 'details','id' => "formDetails$i"]) }}
                {{ Form::hidden('base_url','https://api.edamam.com/search?') }}
                {{ Form::hidden('app_id','8f70bdc3') }}
                {{ Form::hidden('app_key','640a4ca144cbdf75ad7f9ef58fbb6f0a') }}
                {{ Form::text('r',$food['recipe']['uri']) }}
                {{ Form::close() }}
            </div>

            <div class="col-md-3">
                <div class="item">
                    <a href="{{ $i }}" class="detailsLink" title="click for details">
                        <img src="{{ $food['recipe']['image'] }}" alt="">
                        <div class="top">
                            {{ $food['recipe']['label'] }}
                        </div>
                        <div class="middle">
                            <ul>
                                <li class="first"><strong>{{ intval($food['recipe']['calories']) }}</strong> CALORIES
                                </li>
                                <li><strong>{{ count($food['recipe']['ingredientLines']) }}</strong> INGREDIENTS</li>
                            </ul>
                        </div>
                    </a>

                    @if(Auth::guard('web')->check())
                        <div style="display: none">
                            {{ Form::open(['url'=>'#','id'=>"formFav$i"]) }}
                            {{ Form::text('name',$food['recipe']['label']) }}
                            {{ Form::text('r',$food['recipe']['uri']) }}
                            {{ Form::text('image',$food['recipe']['image']) }}
                            {{ Form::text('no_of_ingredients',count($food['recipe']['ingredientLines'])) }}
                            {{ Form::text('calories',intval($food['recipe']['calories'])) }}
                            {{ Form::text('user_id',Auth::guard('web')->user()->id) }}
                            {{ Form::close() }}
                        </div>

                        <div class="bottom">
                            @if(count($favourites) && in_array($food['recipe']['uri'],$favourites))
                                <a href="#" class="btn btn-primary btn-sm" type="button"
                                   style="color: white; background-color: rgb(250, 60, 76); border-color: rgb(250, 60, 76)"><i class="fa fa-star"></i> Favourite</a>
                            @else
                                <a href="{{ $i }}" class="btn btn-primary btn-sm favBtn" id="favLink{{ $i }}" type="button"
                                   style="color: white"><i class="fa fa-plus-circle"></i> Add to Favourite</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <?php $i++; ?>
        @endforeach
    @else
        <div class="col-md-12">
            <div class="item text-center">
                <a href="#">
                    <img src="images/search-bar.gif" alt="">
                </a>
            </div>
        </div>
    @endif
@endsection