<section class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo"><a href="{{ url('/') }}">FOOD LOGO</a></div>
            </div>

            <div class="col-md-6">
            {{ Form::open(['url'=>'search','id'=>'searchForm']) }}
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="myModalLabel">Filter</h3>
                            </div>
                            <div class="modal-body">
                                <div class="form-group col-md-4">
                                    <label>Ingredients</label>
                                    {{ Form::number('ingr',null,['placeholder'=>'Up to','class'=>'form-control']) }}
                                </div>

                                <div class="form-group">
                                    <label>Health</label><br>
                                    {{ Form::checkbox('health[]','alcohol-free') }}Alcohol-Free
                                    {{ Form::checkbox('health[]','vegetarian') }}Vegetarian
                                    {{ Form::checkbox('health[]','peanut-free') }}Peanut Free
                                    {{ Form::checkbox('health[]','soy-free') }}Soy Free <br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center search">
                    <div class="input-group add-on">
                        {{ Form::hidden('base_url','https://api.edamam.com/search?') }}
                        {{ Form::hidden('app_id','8f70bdc3') }}
                        {{ Form::hidden('app_key','640a4ca144cbdf75ad7f9ef58fbb6f0a') }}
                        {{ Form::hidden('from','0') }}
                        {{ Form::hidden('to','20') }}

                        {{ Form::text('q',null,['class'=>'form-control','placeholder'=>'Search for recipe','id'=>'srch-term']) }}

                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="col-md-3">
                <div class="pull-right">
                    @if(Auth::guard('web')->check())

                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button"
                                    data-toggle="dropdown">{{ Auth::guard('web')->user()->username }}
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/') }}">Favourite Item</a></li>
                                <li><a href="{{ url('logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ url('login') }}" class="btn btn-primary" type="button">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center dropdown">
                    @if(Auth::guard('web')->check())
                        Search by <strong data-toggle="modal" data-target="#myModal" style="cursor: pointer">{{ Auth::guard('web')->user()->name }} Filter <i
                                        class="fa fa-caret-down"></i></strong>
                    @else
                        Search by <strong data-toggle="modal" data-target="#myModal" style="cursor: pointer">Filter <i
                                        class="fa fa-caret-down" style="cursor: pointer"></i></strong>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>