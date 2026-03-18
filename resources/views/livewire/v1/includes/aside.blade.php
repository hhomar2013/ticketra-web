<div>
    {{-- Admin Aside --}}
    @role('it')
    @include('livewire.v1.includes.admin-aside')
    @endrole
    {{-- User Aside --}}
    @role('user')
    @include('livewire.v1.includes.user-aside')
    @endrole
</div>
