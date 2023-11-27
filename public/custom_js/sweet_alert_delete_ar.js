$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
          title: 'هل انت متأكد',
          text: "لا يمكن الرجوع لهذه البيانات",
          icon: 'warning',
          showCancelButton: true,
          cancelButtonText: "الغاء", 
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ازالة البيانات'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = link
            Swal.fire(
              'تمت ازالة البيانات',
              'تم بنجاح',
              'success'
            )
          }
        })


    });

  });


