<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="/static/img/logo.png" style="width:142px;height:30px"></img>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            
                <li><a href="{{ route('gallery') }}">{{ t('Gallery') }}</a></li>
                <li><a href="{{ route('users') }}">{{ t('Users') }}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ t('Categories') }}<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @foreach(siteCategories() as $category)
                            <li><a href="{{ route( 'category', ['slug' => $category->slug]) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ t('Popular') }}<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('images.popular') }}">{{ t('Popular') }}</a></li>
                        <li><a href="{{ route('images.featured') }}">{{ t('Featured') }}</a></li>
                        <li><a href="{{ route('images.most.viewed') }}">{{ t('Most Viewed') }}</a></li>
                        <li><a href="{{ route('images.most.commented') }}">{{ t('Most Commented') }}</a></li>
                        <li><a href="{{ route('images.most.favorites') }}">{{ t('Most Favorites') }}</a></li>
                        <li><a href="{{ route('images.most.downloads') }}">{{ t('Most Downloads') }}</a></li>
                    </ul>
                </li>
                <li><a href="#">Forum</a></li>
            </ul>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <form class="navbar-form" role="search" method="GET" action="{{ route('search') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ t('Search') }} " name="q" id="srch-term">

                        <div class="input-group-btn">
                            <button class="btnsearch btnsearch-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check() == false)
                    <li><a href="{{ route('login') }}" class="loginbutton">{{ t('Login') }}</a></li>
                    <li><a href="{{ route('registration') }}" class="registerbutton">{{ t('Register') }}</a></li>
                @else
                    <li><a href="{{ route('images.upload') }}">{{ t('Upload') }}</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php $notifications = (Auth::user()->notifications()->whereIsRead(0)->count()) ?>
                            @if($notifications)
                                <span class="badge badge-danger">{{ $notifications }}</span>
                            @endif&nbsp;
                            {{{ Str::words(Auth::user()->fullname,1,'') }}} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('users.feeds') }}">{{ t('Feeds') }}</a></li>
                            <li><a href="{{ route('notifications') }}">{{ t('Notifications') }}
                                    @if($notifications)
                                        <span class="badge badge-danger">{{ $notifications }}</span>
                                    @endif
                                </a>
                            </li>
                            <li><a href="{{ route('user', ['username' => Auth::user()->username]) }}">{{ t('My Profile') }}</a></li>
                            <li><a href="{{ route('users.settings') }}">{{ t('Profile Settings') }}</a></li>
                            <li><a href="{{ route('logout') }}">{{ t('Logout') }}</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!--/.navbar-collapse -->
         <div class="callit">

</div>
    </div>
</div>
 <!-- Half Page Image Background Carousel Header -->
    <header id="myCarousel" class="carousel slide demo-2" >
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url('/static/img/pozadinska-header.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url('/static/img/pozadinska-header2.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>
            </div>
            <div class="item">
                <!-- Set the third background image using inline CSS below. -->
                <div class="fill" style="background-image:url('/static/img/pozadinska-header3.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
        <script src="/static/js/rAF.js"></script>
        <script src="/static/js/demo-2.js"></script>
    </header>
