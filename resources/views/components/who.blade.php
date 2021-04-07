@if(Auth::guard('web')->check())
<p class="text-success">Your are Logged in as <strong>USER</strong></p>
@else
<p class="text-danger">Your are Logged out as <strong>USER</strong></p>
@endif

@if(Auth::guard('admin')->check())
<p class="text-success">Your are Logged in as <strong>ADMIN</strong></p>
@else
<p class="text-danger">Your are Logged out as <strong>ADMIN</strong></p>
@endif
