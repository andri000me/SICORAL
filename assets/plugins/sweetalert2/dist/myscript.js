const flashData = $('.flash-data').data('flashdata');

if (flashData) {
  Swal.fire({
    title: 'Data',
    text: 'Berhasil' + flashData,
    icon: 'success'
  });
}

$('.remove').on('click', function (e) {
  e.preventDefault();
  const href = $(this).attr('href');

  Swal.fire({
  title: 'Apakah Kamu Yakin?',
  text: "Data yang dihapus tidak dapat kembalikan",
  icon: 'warning',
  showCancelButton: true,
  cancelButtonText: 'Batal',
  cancelButtonColor: '#d33',
  confirmButtonColor: '#3085d6',
  confirmButtonText: 'Ya, Hapus!'
}).then((result) => {
  if (result.value) {
    document.location.href = href;
  }
})

});
