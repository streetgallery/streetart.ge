 <div class="backdiv"><a class="backarticle"  onclick="goBack()" href="#back"><i class="back"></i>@lang('site.Back')</a></div>



 @if(App::isLocale('ka'))
     <h1>{{ $item->name }}</h1>
 @endif

 @if(App::isLocale('en'))
     <h1>{{ $item->name_en }}</h1>
 @endif

@if(isset($item->images[0]->medium))
    <div class="article-img">
        <img src="{{ asset($item->images[0]->medium) }}">
    </div>
@endif



 @if(App::isLocale('ka'))
     <div>{!! $item->content !!}</div>
  @endif

 @if(App::isLocale('en'))
     <div>{!! $item->content_en !!}</div>
 @endif

 <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>


 <script>


     if (document.referrer == "") {
         $( ".backdiv" ).hide();
     }

     function goBack() {
         window.history.back();
     }

 </script>
