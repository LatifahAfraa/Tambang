$(document).on('click', '.btn-hapus', function(e) {
    $this = $(this);
    e.preventDefault();
    bootbox.confirm({
        size: "small",
        message: "Yakin hapus data ini?",
        callback: function(result) {
            if (result == true) {
                $this.next('form').submit();
            }
        }
    })
});