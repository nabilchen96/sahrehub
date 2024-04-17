bookmarkPost = (id) => {

    axios.post('/bookmark-post', {
        id
    })
        .then((response) => {
            if (response.data.responCode == 1) {
                var total_like = response.data.message.total_bookmark
                var id = response.data.id
                document.getElementById(`totalBookmarkValue${id}`).innerHTML = total_like

                //toggle bookmarked icon
                var bookmarkIcon = document.getElementById(`bookmark${id}`);
                if (bookmarkIcon.classList.contains('bi-bookmark-fill')) {
                    bookmarkIcon.classList.remove('bi-bookmark-fill');
                    bookmarkIcon.classList.add('bi-bookmark');
                } else {
                    bookmarkIcon.classList.remove('bi-bookmark');
                    bookmarkIcon.classList.add('bi-bookmark-fill');
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