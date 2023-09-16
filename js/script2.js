function showConfirmation2(id, Kategori) {
    const popup = document.getElementById("popup");
    const confirmButton = document.getElementById("confirm-button");


    const deleteUrl = `?mod=${Kategori}&act=hapus&id=${id}`;
    confirmButton.setAttribute("href", deleteUrl);
    console.log(Kategori, "testing");

    popup.style.display = "flex";
}