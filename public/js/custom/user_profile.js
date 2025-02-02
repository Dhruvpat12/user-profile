$("#edit-user-profile").submit(function(event){
   
    event.preventDefault();
    if($("#edit-user-profile").valid())
     {
    var formData = new FormData(this);
    var id=$("#edit-user-profile")[0].action
    $.ajax({
 
        type:'POST',
        url:id,
        data: formData,
         processData: false,
         contentType: false,
        dataType: "json",
        success: function(response){
            
         //    toastr.success(response.statusMsg);
            window.location.href = '/profile';
            // toastr.success(response.statusMsg);
        }
 
 
    });
  }
 });