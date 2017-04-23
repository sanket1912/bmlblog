<!-- Header -->
<div id="header">
    <div class="container"> 

        
        
        
        
        <!-- Nav -->
        <!-- <nav id="nav">
            <ul>
                <li class="{{ Request::is('/') ? "active" : ""}}"><a href="/">Home</a></li>
                <li class="{{ Request::is('blog') ? "active" : ""}}"><a href="/blog">Archive</a></li>
                @if (Auth::check())
                    <li class="{{ Request::is('posts/create') ? "active" : ""}}"><a href="{{ route('posts.create') }}">Create Post</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span> Hello {{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('posts.index') }}">Posts</a></li>
                            <li><a href="{{ route('categories.index') }}">Category</a></li>
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    <a href="{{ route('login') }}">LOGIN</a>
                @endif
            </ul>
        </nav> -->
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <!--<a class="navbar-brand" href="/">BML Blog</a>-->
              <a class="navbar-brand" href="/"><img alt="BML Blog" src="http://static-collegedunia.com/public/college_data/images/logos/147730738612.jpg" style="max-height: 100%;float: left;"> BML Blog</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="{{ Request::is('/') ? "active" : ""}}"><a href="/">Home</a></li>
                <li class="{{ Request::is('blog') ? "active" : ""}}"><a href="/blog">Archive</a></li>
                @if (Auth::check())
                    <li class="{{ Request::is('posts/create') ? "active" : ""}}"><a href="{{ route('posts.create') }}">Create Post</a></li>
                @else
                   <li> <a href="{{ route('login') }}">LOGIN</a></li>
                @endif
              </ul>
              <ul class="nav navbar-nav" style="float: right;">
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span> Hello {{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('posts.index') }}">Posts</a></li>
                            <li><a href="{{ route('categories.index') }}">Category</a></li>
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    
                @endif
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <!-- Logo -->
        <div id="logo">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
        </div>
    </div>
</div>