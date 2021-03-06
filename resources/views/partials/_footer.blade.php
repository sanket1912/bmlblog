<footer><!-- Footer -->
    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="4u">
                    <section>
                        <div class="widget">
                            <h2 class="title">About me</h2>
                            <div class="sidebar_about_author">
                                <div class="inner_wrapper">
                                    <div class="author_img">
                                        <img alt="BML Logo" class="img-responsive" src="https://pbs.twimg.com/profile_images/720225801942138881/Cv1DWlGo.jpg">
                                    </div>
                                </div>
                                <div class="author_info">
                                    <h4>BMU BLOG</h4>
                                    <p>BML Munjal University (BMU) seeks to transform higher education in India by creating a world class and innovative teaching, learning and research environment. Founded by the Hero Group and mentored by Imperial College London, BMU is a not-for-profit initiative offering undergraduate and post-graduate courses. BMU offers management courses (MBA & BBA), engineering courses (BTech) and BCom courses.</p>
                                    <br>
                                    
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </section>
                </div>
                <div class="4u">
                    <section>
                        <div class="widget ContactForm">
                            <h2 class="title">Contact Us</h2>
                            <div class="contact-form-widget">
                                <div class="form">
                                    @if(Session::has('message'))
                                        <div>
                                            {{ Session::pull('message') }}
                                        </div>
                                    @endif
                                    @if(! $errors->isEmpty())
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    {!! Form::open(array('route' => 'sendmail', 'data-parsley-validate' => '', 'method' => 'POST')) !!}
                                        <div class="form-group">
                                            {{ Form::text('name', null, array('required', 'placeholder'=>'Your name', 'class' => 'contact-form-name', 'id' => 'ContactForm1_contact-form-name', 'required' => '')) }}
                                        </div>

                                        <div class="form-group">    
                                            {{ Form::text('email', null, array('placeholder'=>'Your e-mail', 'class' => 'contact-form-email', 'id' => 'ContactForm1_contact-form-email', 'required' => '', 'type' => 'email')) }}
                                        </div>

                                        <div class="form-group">    
                                            {{ Form::textarea('message', null, array('required', 'placeholder'=>'Your message', 'class' => 'contact-form-email-message', 'id' => 'ContactForm1_contact-form-email-message', 'cols' => '25', 'rows' => '5')) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::submit('Contact Us!', array('class' => 'contact-send')) }}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </section>
                </div>
                <div class="4u">
                    <section>
                        <div class="widget HTML" data-version="1" id="HTML3">
                            <h2 class="title">Subscribe us</h2>
                                <div id="blog_newsletter">
                                <h5>Subscribe Our Newsletter</h5>
                                <p>Enter your email address below to subscribe to our newsletter.</p>
                                <div class="input-append">
                                    {!! Form::open(array('route' => 'subscriberStore', 'data-parsley-validate' => '', 'method' => 'POST')) !!}

                                        {{ Form::text('email', null, array('placeholder'=>'E-mail Address','id' => 'subbox', 'required' => '', 'type' => 'email')) }}

                                        {{ Form::submit('Subscribe!', array('id' => 'subbutton')) }}

                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</footer>