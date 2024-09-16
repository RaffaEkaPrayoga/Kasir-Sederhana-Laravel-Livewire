import './bootstrap';

import Swal from 'sweetalert2';

window.addEventListener('swal:confirm', event => {
    Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.icon,
        showCancelButton: event.detail.showCancelButton,
        confirmButtonColor: event.detail.confirmButtonColor,
        cancelButtonColor: event.detail.cancelButtonColor,
        confirmButtonText: event.detail.confirmButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('swal:confirm', { isConfirmed: true });
        } else {
            Livewire.dispatch('swal:confirm', { isConfirmed: false });
        }
    });
});

window.addEventListener('swal:message', event => {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: event.detail.message,
        showConfirmButton: true,
        timer: 1500
    });
});
