@extends('layouts.app')




@section('content')

@if (count($links)==0)
<div class="blank-slate-pf">
  <div class="blank-slate-pf-icon">
    <span class="pficon pficon pficon-add-circle-o"></span>
  </div>
  <h1>
  @lang('messages.emptystate_title')
  </h1>
  <p>
  @lang('messages.emptystate_description')
  </p>
  
  <div class="blank-slate-pf-main-action">
    <a href="{{action('LinkController@create')}}" class="btn btn-primary btn-lg"> @lang('messages.create') </a>
  </div>
  
</div>
@else

    
<div class="container">
<div class="row">

<a href="{{action('LinkController@create')}}" class="pull-right btn btn-primary btn-lg"> @lang('messages.create') </a>
<h1>@lang('messages.link_list')</h1>

</div>

@if (\Session::has('success'))
<div class="row">
<br />
<div class="alert alert-success">
<p>{{ \Session::get('success') }}</p>
</div><br />
</div>
@endif

</div>

<div class="container-fluid">

<div id="pf-list-standard" class="list-group list-view-pf list-view-pf-view">
  
@foreach($links as $link)
  <div class="list-group-item">
    
    <div class="list-view-pf-actions">
      <a href="{{action('LinkController@edit', $link->id)}}" class="btn btn-default">@lang('messages.edit')</a>
      <form action="{{action('LinkController@destroy', $link->id)}}" method="post" style="display:inline-block;">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-default" type="submit">@lang('messages.delete')</button>
      </form>      

    </div>
    <div class="list-view-pf-main-info">      
      <div class="list-view-pf-body">
        <div class="list-view-pf-description">
          <div class="list-group-item-heading">            
            
            <div class="list-view-pf-additional-info-item">
            <span class="pficon pficon-screen"></span>
            <strong>{{ $link->nb_click }}</strong> @lang('messages.clicks')
          </div> 
          </div>
          <div class="list-group-item-text">
          <a target="_blank" href="{{ route('shorturl', $link->shortURL) }}">{{ route('shorturl', $link->shortURL) }}</a>
             
          </div>
        </div>
        <div class="list-view-pf-additional-info">
        {{ $link->url }}
             <br/>
             @lang('messages.updated_at') : {{ $link->updated_at }}      
        </div>
      </div>
    </div>
  </div>
@endforeach
  
  </div>
</div>

</div>

@endif

@endsection