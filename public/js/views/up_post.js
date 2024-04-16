upPost = (id) => {

    axios.post('/up-post', {
        id
    })
        .then((response) => {
            if (response.data.responCode == 1) {
                var total_up = response.data.message.total_up
                var id = response.data.id
                document.getElementById(`totalUpValue${id}`).innerHTML = total_up

                //toggle liked icon
                var upIcon = document.getElementById(`up${id}`);
                if (upIcon.classList.contains('bi-arrow-up-circle-fill')) {
                    upIcon.classList.remove('bi-arrow-up-circle-fill');
                    upIcon.classList.add('bi-arrow-up-circle');
                } else {
                    upIcon.classList.remove('bi-arrow-up-circle');
                    upIcon.classList.add('bi-arrow-up-circle-fill');
                }

            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Gagal...',
                    text: response.data.respon,
                })
            }
        }, (error) => {
            console.log(error);
        });
}