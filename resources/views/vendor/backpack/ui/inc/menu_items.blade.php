{{-- This file is used for menu items by any Backpack v6 theme --}}
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('ULTIMATE TEAM RACE') }}</a></li>--}}


@if(backpack_auth()->user()->hasRole('root'))
    <x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
    <x-backpack::menu-item title="Equipes" icon="la la-question" :link="backpack_url('equipe')" />
    <x-backpack::menu-item title="Etapes" icon="la la-question" :link="backpack_url('etape')" />
    <x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
    <x-backpack::menu-item title="Coureurs" icon="la la-question" :link="backpack_url('coureur')" />
    <x-backpack::menu-item title="Resultats" icon="la la-question" :link="backpack_url('resultat')" />
    <x-backpack::menu-item title="Points" icon="la la-question" :link="backpack_url('point')" />
@else
    <x-backpack::menu-item title="Resultats" icon="la la-question" :link="backpack_url('resultat')" />
@endif
