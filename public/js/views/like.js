likePost = (id) => {

    axios.post('/like-post', {
        id
    })
        .then((response) => {
            if (response.data.responCode == 1) {
                var total_like = response.data.message.total_like
                var id = response.data.id
                document.getElementById(`totalLikeValue${id}`).innerHTML = total_like

                //toggle liked icon
                var likeIcon = document.getElementById(`like${id}`);
                if (likeIcon.classList.contains('bi-heart-fill')) {
                    likeIcon.classList.remove('bi-heart-fill');
                    likeIcon.classList.add('bi-heart');
                } else {
                    likeIcon.classList.remove('bi-heart');
                    likeIcon.classList.add('bi-heart-fill');
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