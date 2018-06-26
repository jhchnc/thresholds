@extends('layouts.issue')

@section('styles') 
	@foreach( $issue->articles() as $article )
		{!! $article->sass_string !!}
	@endforeach
@stop

@section('content')

	<script>
		window.IssueArticlesCache = {};
	</script>
	<div id="main" class="container-fluid" style="margin:0;padding:0;">
		<div class="panel panel-default" style="border:none;">
			<div class="panel-body pull-left">
				@foreach( $issue->articles() as $article )
					<div id="" class="article article_id_{{ $article->id }} 
						@if ($init_article_alias == $article->alias)
							init_article
						@endif
						@if ($article->background_image) 
							background_image 
						@endif" 
						data-alias = "{{ $article->alias }}"
						data-url="/article/{{ $article->id }}"
						@if ($article->background_image)
							data-background="url({{$article->background_image}})"
						@endif
						>

						<div class="article-left pull-left" ><div class="article-left-wrapper">
							<?php ob_start(); ?>
							{!! $article->displayLazyContent() !!}
							<?php $left = ob_get_clean(); ?>
						</div></div>

						<div class="article-right pull-right"><div class="article-right-wrapper">
							<?php ob_start(); ?>
							@foreach( $article->fragments() as $fragment )
								<div class="fragment {{ $fragment->css_class }}" id="fragment_id_{{ $fragment->id }}">{!! $fragment->displayLazyContent() !!}</div>
							@endforeach
							<?php $right = ob_get_clean(); ?>
						</div></div>

						<script>
							IssueArticlesCache['{{ $loop->index }}'] = {};
							IssueArticlesCache['{{ $loop->index }}']['left'] = {!! json_encode($left) !!};
							IssueArticlesCache['{{ $loop->index }}']['right'] = {!! json_encode($right) !!};
							IssueArticlesCache['{{ $loop->index }}']['active'] = 0;
						</script>

						<div class="article-fade"></div>
						<h2 class="article-title"><span>{{ $article->title }}<small>{{ $article->byline }}</small></span></h2>
					</div>
				@endforeach
			</div>
		</div>
	</div>

	<div id="article_toc_container" class="container-fluid" style="margin:0;padding:0;">
		<div class="article_toc article_toc_bottom">
		</div>
	</div>

@stop
