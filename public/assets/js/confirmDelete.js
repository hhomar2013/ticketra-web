function confirmDelete(id, event) {
    Swal.fire({
        title: 'Are you sure ?',
        text: "The record will be permanently deleted !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes ,delete ✔️',
        cancelButtonText: 'Cancel ❌',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch(event, {
                id: id
            });
        }
    })
}




