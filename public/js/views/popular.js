function loadPopular() {
    axios.get(`data-popular`).then(response => {
        let items = response.data;
        let tags = '';

        items.slice(0, 15).forEach(item => { // Menggunakan slice untuk membatasi 10 elemen pertama
            tags += `
                <p>
                    <b>
                        <a href="/eksplor?id=${item.tag}">
                            #${item.tag}
                        </a>
                    </b>
                </p>
            `;
        });

        document.getElementById('tagPopular').innerHTML = tags;
    });
}