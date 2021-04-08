let flashData = $(".flash-data").data("flashdata");
let flashDataError = $(".flash-data-error").data("flashdata");

if (flashData) {
    Swal.fire('Success',`${flashData}`, "success");
}

if(flashDataError){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${flashDataError}`,
    })
}

function deleteConfirmation(e) {
    var id = e;
    title = $(".swal-confirm").data("title");
    Swal.fire({
      title: `Are you sure ? delete data ${title}`,
      text: `You won't be able to revert this!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then(result => {
      if (result.value) {
        $(`#delete${id}`).trigger("submit");
      } else {
        // Swal.fire('Oke');
      }
    });
  }