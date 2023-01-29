<div class="profile_navbar   " >
    <a href="{{ asset('account/profile') }}" class="@if(isset($menu) && $menu == 'profile') active @endif ">@lang('site.Edit Profile')</a>
    <a href="{{ asset('account/avatar') }}" class="@if(isset($menu) && $menu == 'avatar') active @endif ">@lang('site.Avatar')</a>
    <a href="{{ asset('account/social_profiles') }}" class="@if(isset($menu) && $menu == 'social_profiles') active @endif">@lang('site.Social Profiles')</a>
    <a href="{{ asset('account/password') }}" class="@if(isset($menu) && $menu == 'password') active @endif">@lang('site.Password')</a>
    <!--<a href="{{ asset('account/location') }}" class="@if(isset($menu) && $menu == 'location') active @endif">@lang('site.Location')</a>
    <a href="{{ asset('account/billing') }}" class="@if(isset($menu) && $menu == 'billing') active @endif">@lang('site.Billing Information')</a>
    -->
</div>