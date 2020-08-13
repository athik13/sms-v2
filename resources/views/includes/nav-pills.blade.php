<ul class="nav nav-pills justify-content-center">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('sms') ? 'active' : '' }}" href="/sms">Single SMS</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{ Request::is('sms/group') ? 'active' : '' }}" href="/sms/group">Group SMS</a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('sms/sent') ? 'active' : '' }}" href="/sms/sent">Sent Messages</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{ Request::is('sms/groups/manage') ? 'active' : '' }}" href="/sms/groups/manage">Manage SMS groups</a>
    </li> --}}
    @role('admin')
    @can('view received messages')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('received-sms') ? 'active' : '' }}" href="/received-sms">View Received Messages</a>
    </li>
    @endcan
    @endrole
    @role('admin')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" href="/users">Manage Users</a>
    </li>
    @endrole
</ul>