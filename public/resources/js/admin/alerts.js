import Swal from 'sweetalert2';

// Подтверждение
const confirm2 = (callback, confirmText="") => {
    Swal.fire({
        title: 'Вы уверены?',
        text: confirmText, 
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#FA1F61',
        cancelButtonColor: '#9CA8BA',
        confirmButtonText: 'Да, уверен',
        cancelButtonText: 'Отмена',
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    })
}

// Сообщение об успехе
const success2 = (text) => {
    Swal.fire({
        icon: 'success',
        title: text,
        showConfirmButton: false,
        timer: 2500,
        confirmButtonText: 'Ок',
        confirmButtonColor: '#13BC57',
        showConfirmButton: true
      })
}

export {confirm2, success2};