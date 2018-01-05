@extends('private.home.layout')

@section('formJS')
    <script>
        $('.favBtn').click(function (e) {
            e.preventDefault();

            request = $.ajax({
                url: '../add-to-favorite',
                type: 'POST',
                data: $('#formFav').serialize()
            });

            request.done(function (data, textStatus, jqXHR) {
                result = jQuery.parseJSON(data);
                if (result.isOK === true) {
                    $('#favLink').html("<i class='fa fa-star'></i> Favourite");
                    $('#favLink').css('background-color', 'rgb(250, 60, 76)');
                    $('#favLink').css('border-color', 'rgb(250, 60, 76)');
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="col-md-9">
        <div class="details">
            <div class="row ">
                <div class="col-md-6">
                    <img src="{{ $response['image'] }}" alt="Image">
                </div>
                <div class="col-md-6">
                    <div class="right">
                        <div class="top">
                            <h4>{{ $response['label'] }}</h4>
                            <p>See full recipe on <a href="{{ $response['url'] }}"
                                                     target="_blank">{{ $response['source'] }}</a></p>
                        </div>
                        <div class="bottom text-center">
                            @if(Auth::guard('web')->check())
                                <div style="display: none">
                                    {{ Form::open(['url'=>'#','id'=>"formFav"]) }}
                                    {{ Form::text('name',$response['label']) }}
                                    {{ Form::text('r',$response['uri']) }}
                                    {{ Form::text('image',$response['image']) }}
                                    {{ Form::text('no_of_ingredients',count($response['ingredientLines'])) }}
                                    {{ Form::text('calories',intval($response['calories'])) }}
                                    {{ Form::text('user_id',Auth::guard('web')->user()->id) }}
                                    {{ Form::close() }}
                                </div>

                                <p class="">
                                    @if(count($favourites) && in_array($response['uri'],$favourites))
                                        <a href="#" class="btn btn-primary btn-sm" type="button"
                                           style="color: white; background-color: rgb(250, 60, 76); border-color: rgb(250, 60, 76)"><i
                                                    class="fa fa-star"></i> Favourite</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm favBtn" id="favLink" type="button"
                                           style="color: white"><i class="fa fa-plus-circle"></i> Add to Favourite</a>
                                    @endif
                                </p>
                            @endif

                            <p class="share">
                                <a href="#" class=""><i class="fa fa-envelope-square"> <br>
                                        <span>email</span></i></a>
                                <a href="#" class=""><i class="fa fa-facebook-official"> <br> <span>share</span></i></a>
                                <a href="#" class=""><i class="fa fa-pinterest-square"> <br> <span>pin it</span></i></a>
                                <a href="#" class=""><i class="fa fa-twitter-square"> <br>
                                        <span>tweet</span></i></a>
                                <a href="#" class=""><i class="fa fa-google-plus-square"> <br>
                                        <span>google+</span></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="details-bottom">
            <div class="row">
                <div class="col-md-6">
                    <h3>{{ count($response['ingredientLines']) }} Ingredients</h3>
                    @if(count($response['ingredientLines']))
                        <ol>
                            @foreach($response['ingredientLines'] as $ingredientLine)
                                <li>{{ $ingredientLine }}</li>
                            @endforeach
                        </ol>
                    @endif

                    <div class="col-md-12 digit-wrap">
                        <h3>Daily Nutrition</h3>
                        <table class="table table-responsive">
                            <tr>
                                <th>Nutrition</th>
                                <th>Quantity</th>
                                <th>Percent</th>
                            </tr>
                            @if(count($response['totalDaily']))
                                @foreach($response['totalDaily'] as $nutrient)
                                    <tr>
                                        <td>{{ $nutrient['label'] }}</td>
                                        <td>{{ $nutrient['quantity'] }}</td>
                                        <td>{{ $nutrient['unit'] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3>Nutrition</h3>
                    <div class="row">
                        <div class="col-md-4 digit-wrap">
                                   <span class="digit">
                                       {{ intval($response['calories']) }}
                                   </span>
                            <br>
                            calories / serving
                        </div>
                        {{--<div class="col-md-4 digit-wrap">--}}
                        {{--<span class="digit">--}}
                        {{--17%--}}
                        {{--</span>--}}
                        {{--<br>--}}
                        {{--daily value--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4 digit-wrap">--}}
                        {{--<span class="digit label label-default">--}}
                        {{--18--}}
                        {{--</span>--}}
                        {{--<br>--}}
                        {{--serving--}}
                        {{--</div>--}}

                        <div class="col-md-12 digit-wrap">
                            <table class="table table-responsive">
                                <tr>
                                    <th>Nutrition</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                </tr>
                                @if(count($response['totalNutrients']))
                                    @foreach($response['totalNutrients'] as $nutrient)
                                        <tr>
                                            <td>{{ $nutrient['label'] }}</td>
                                            <td>{{ $nutrient['quantity'] }}</td>
                                            <td>{{ $nutrient['unit'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @if(count($suggestion['hits']))
            <h3>Try also</h3>
            <?php $i = 1; ?>
            @foreach($suggestion['hits'] as $food)
                <div style="display: none">
                    {{ Form::open(['url' => 'details','id' => "formDetails$i"]) }}
                    {{ Form::hidden('base_url','https://api.edamam.com/search?') }}
                    {{ Form::hidden('app_id','8f70bdc3') }}
                    {{ Form::hidden('app_key','640a4ca144cbdf75ad7f9ef58fbb6f0a') }}
                    {{ Form::text('r',$food['recipe']['uri']) }}
                    {{ Form::close() }}
                </div>

                <div class="item">
                    <a href="#" class="detailsLink">
                        <img src="{{ $food['recipe']['image'] }}" alt="Image">
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
                </div>
            @endforeach
            <?php $i++; ?>
        @endif
    </div>
@endsection