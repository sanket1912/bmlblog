@extends('main')

@section('title',"| Edit Comment")

@section('content')

	<section class="col-md-8">
			<h4 class="title">Edit Comment</h4>
			{!! Form::model($comment, ['route' => ['comments.update', $comment->name], 'method' => 'PUT']) !!}
				
				{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Your Name']) }}

				{{ Form::textarea('content', null, ['class' => 'form-control form-spacing-top', 'placeholder' => 'Comment Here..', 'rows' => '5']) }}

				{{ Form::submit('Comment', array('class' => 'btn btn-primary form-spacing-top')) }}

				{!! Form::close() !!}

			
	</section>

@stop