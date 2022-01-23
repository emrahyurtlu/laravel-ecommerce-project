$(document).ready(function () {
    $("a.list-item-delete").on("click", function (e) {
        e.preventDefault()
        let url = $(this).attr("href")
        if (url !== null) {
            let confirmation = confirm("Bu kaydı silmek istediğinize emin misiniz?");
            if (confirmation) {
                axios.delete(url).then(result => {
                    console.log(result.data)
                    $("#" + result.data.id).remove()
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    })
})
