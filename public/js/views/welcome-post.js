function loadItems(page) {
    axios.get(`data-post?page=${page}`)
        .then(response => {
            const items = response.data.data;
            const itemsDiv = document.getElementById('postingan');
            let mediaElement = ``

            items.forEach(item => {
                let liked = '';
                let bookmarked = '';
                if (id_loggedin != 0) {
                    if (id_loggedin == parseInt(item.id_user_like)) {
                        liked = `
                            <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="likePost('${item.id}')">
                                <i id="like${item.id}" style="font-size: 1.3rem;" class="bi bi-heart-fill text-danger"></i> <br>
                                <span style="font-size: 12px;" id="totalLikeValue${item.id}">${item.total_like}</span>
                            </a>
                        `;
                    } else {
                        liked = `
                            <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="likePost('${item.id}')">
                                <i id="like${item.id}" style="font-size: 1.3rem;" class="bi bi-heart text-danger"></i> <br>
                                <span style="font-size: 12px;" id="totalLikeValue${item.id}">${item.total_like}</span>
                            </a>
                        `;
                    }

                    if (id_loggedin == item.id_user_up) {
                        uped = `
                            <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="upPost('${item.id}')">
                                <i id="up${item.id}" style="font-size: 1.3rem;" class="bi bi-arrow-up-circle-fill text-primary"></i> <br>
                                <span style="font-size: 12px;" id="totalUpValue${item.id}">${item.total_up}</span>
                            </a>
                        `;
                    } else {
                        uped = `
                            <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="upPost('${item.id}')">
                                <i id="up${item.id}" style="font-size: 1.3rem;" class="bi bi-arrow-up-circle text-primary"></i> <br>
                                <span style="font-size: 12px;" id="totalUpValue${item.id}">${item.total_up}</span>
                            </a>
                        `;
                    }

                    if (id_loggedin == item.id_user_bookmark) {
                        bookmarked = `
                            <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="bookmarkPost('${item.id}')">
                                <i id="bookmark${item.id}" style="font-size: 1.3rem;" class="bi bi-bookmark-fill text-warning"></i> <br>
                                <span style="font-size: 12px;" id="totalBookmarkValue${item.id}">${item.total_bookmark}</span>
                            </a>
                        `;
                    } else {
                        bookmarked = `
                            <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="bookmarkPost('${item.id}')">
                                <i id="bookmark${item.id}" style="font-size: 1.3rem;" class="bi bi-bookmark text-warning"></i> <br>
                                <span style="font-size: 12px;" id="totalBookmarkValue${item.id}">${item.total_bookmark}</span>
                            </a>
                        `;
                    }
                } else {
                    liked = `
                        <a style="color: black; text-decoration: none;" href="javascript:void(0)">
                            <i id="like${item.id}" style="font-size: 1.3rem;" class="bi bi-heart text-danger"></i> <br>
                            <span style="font-size: 12px;" id="totalLikeValue${item.id}">${item.total_like}</span>
                        </a>
                    `;

                    uped = `
                        <a style="color: black; text-decoration: none;" href="javascript:void(0)">
                            <i id="up${item.id}" style="font-size: 1.3rem;" class="bi bi-arrow-up-circle text-primary"></i> <br>
                            <span style="font-size: 12px;" id="totalUpValue${item.id}">${item.total_up}</span>
                        </a>
                    `;

                    bookmarked = `
                        <a style="color: black; text-decoration: none;" href="javascript:void(0)">
                            <i id="bookmark${item.id}" style="font-size: 1.3rem;" class="bi bi-bookmark text-warning"></i> <br>
                            <span style="font-size: 12px;" id="totalBookmarkValue${item.id}">${item.total_bookmark}</span>
                        </a>
                    `;
                }

                // Memeriksa tipe media
                if (item.media.endsWith('.mp4')) {

                    mediaElement = `
                    <video controls loop style="border-radius: 10px;" class="rounded-3 w-100">
                        <source src="/media/${item.media}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    `

                } else {

                    mediaElement = `
                    <a href="/detail-post?id=${item.id}" style="text-decoration: none; color: black;">
                        <img style="border-radius: 10px;" 
                        src="/media/${item.media}"
                        class="rounded-3 w-100" alt="Image">
                    </a>
                    `
                }

                const div = document.createElement('div');
                div.innerHTML = `
                <div class="col-lg-12 mb-5 p-0 px-lg-3">
                    <div class="p-0 px-lg-2">
                        <div class="d-flex justify-content-between">
                            <a style="color: black; text-decoration: none;" href="/profil?id=${item.id_user}" 
                                class="d-flex align-items-center mb-2">
                                <div>
                                    <img style="width: 35px; height: 35px; object-fit: cover;" src="/profile/${item.photo}"
                                        alt="Image" class="mr-3 avatar avatar-md rounded-circle">
                                </div>
                                
                                <div class="ms-2">
                                    <h5 style="font-size: 14px;" class="mb-0">${item.name}</h5>
                                    <p style="font-size: 12px; " class="mb-0">${timeAgo(item.created_at)}</p>
                                </div>
                            </a>
                            <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                                <i style="font-size: 1.3rem;" class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <b>Share to Social Media</b>
                                    </a>
                                    <hr>
                                </li>
                                <li><a class="dropdown-item" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=/detail-post/?id=${item.id}"><i class="bi bi-facebook text-info"></i> &nbsp; Facebook</a></li>
                                <li><a class="dropdown-item" target="_blank" href="https://twitter.com/intent/tweet?url=/detail-post/?id=${item.id}"><i class="bi bi-twitter text-info"></i> &nbsp; Twitter</a></li>
                                <li><a class="dropdown-item" target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=/detail-post/?id=${item.id}"><i class="bi bi-linkedin text-info"></i> &nbsp; Linkedin</a></li>
                                <li><a class="dropdown-item" target="_blank" href="https://pinterest.com/pin/create/button/?url=/detail-post/?id=${item.id}"><i class="bi bi-pinterest text-danger"></i> &nbsp; Pinterest</a></li>
                                <li><a class="dropdown-item" target="_blank" href="https://web.whatsapp.com/send?text=/detail-post/?id=${item.id}"><i class="bi bi-whatsapp text-success"></i> &nbsp; Whatsapp</a></li>
                            </ul>
                        </div>
                        ${mediaElement}
                        <div class="p-2 d-flex justify-content-between mt-3 mt-lg-2 align-items-center">
                            <div class="mr-4 text-center">
                                ${liked}
                            </div>
                            <div class="mr-4 text-center">
                                <a href="/detail-post?id=${item.id}" style="text-decoration: none; color: black;">
                                    <i style="font-size: 1.3rem;" class="bi bi-chat-right-text text-info"></i> <br>
                                    <span style="font-size: 12px;">${item.total_comment}</span>
                                </a>
                            </div>
                            <div class="mr-4 text-center">
                                ${uped}
                            </div>
                            <div class="text-center"> <!-- Tambahkan kelas text-center di sini -->
                                ${bookmarked}
                            </div>

                        </div>
                        <div class="pr-2 pl-2">
                            <br>
                            <p>
                                ${item.keterangan}
                                <br>
                                <div class="text-info mt-1">
                                    ${item.tag.split(',').map(tag => `<a href="eksplor?id=${tag.trim()}">#${tag.trim()}</a>`).join(' ')}
                                </div>
                            </p>
                            <hr>
                        </div>
                    </div>
                </div> 
                        `;
                itemsDiv.appendChild(div);
            });

            currentPage++;
        });
}
