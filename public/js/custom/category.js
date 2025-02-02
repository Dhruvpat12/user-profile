$("#add-categoryes").submit(function(e) {
    e.preventDefault();

    if ($("#add-categoryes").valid()) {
        var url = $("#add-categoryes").data('action');
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                window.location.href = 'show-category-list';
            },
            error: function(xhr) {
                if (xhr.status === 422) { // Laravel validation error
                    var errors = xhr.responseJSON.errors;
                    $(".error-message").remove(); // Remove previous errors

                    $.each(errors, function(field, messages) {
                        var input = $("[name='" + field + "']");
                        input.after("<span class='error-message text-danger'>" + messages[0] + "</span>");
                    });
                    $.each(errors, function(field, messages) {
                        var input = $("[slug='" + field + "']");
                        input.after("<span class='error-message text-danger'>" + messages[0] + "</span>");
                    });
                }
            }
        });
    }
});

$("#edit-category").submit(function(event){
   
    event.preventDefault();
    if($("#edit-category").valid())
     {
    var formData = new FormData(this);
    var id=$("#edit-category")[0].action
    $.ajax({
 
        type:'POST',
        url:id,
        data: formData,
         processData: false,
         contentType: false,
        dataType: "json",
        success: function(response){
            
         //    toastr.success(response.statusMsg);
            window.location.href = '/show-category-list';
            // toastr.success(response.statusMsg);
        }
 
 
    });
  }
 });
$('#show-category').DataTable({
    processing: true,
    serverSide: true,
    method: 'POST',
    ajax: {
        url:'/list-category-data',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         } 
    },
     columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'slug' },
        { data: 'parent_id' },
        { data: 'category_image' },
   



        { data: 'action', orderable: false, searchable: false }
   
    ],
})