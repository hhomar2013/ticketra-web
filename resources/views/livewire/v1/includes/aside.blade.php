<div>
    {{-- Admin Aside --}}
    @role('admin')
        @include('livewire.v1.includes.admin-aside')
    @endrole
    {{-- User Aside --}}
    @role('user')
        @include('livewire.v1.includes.user-aside')
    @endrole
</div>
