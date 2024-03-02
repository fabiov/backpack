{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Accounts" icon="la la-question" :link="backpack_url('account')" />
<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
<x-backpack::menu-item title="Movements" icon="la la-question" :link="backpack_url('movement')" />
<x-backpack::menu-item title="Provisions" icon="la la-question" :link="backpack_url('provision')" />