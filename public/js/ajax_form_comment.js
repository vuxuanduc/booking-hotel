$(document).ready(function(){
    $('#form-add-comment').on('submit' , function(event){
        event.preventDefault() ;
        let comment = $('textarea[name="content_comment"]').val().trim() ;
        let email = $('input[name="email"]').val() ;
        let hotelId = $('input[name="hotel_id"]').val() ;
        let csrfToken = $(this).find('input[name="_token"]').val() ;
        let actionUrl = $(this).attr('action');
        

        $('.error').text('') ;

        $.ajax({
            url : actionUrl ,
            type : 'POST' ,
            data : {
                content_comment : comment ,
                email : email ,
                hotel_id : hotelId ,
                _token : csrfToken
            } ,
            dataType : 'json' ,
            success : function(response) {
                addNewComment(response.data) ;

                $('#form-add-comment')[0].reset();
            } ,

            error: function(error) {
                if (error.responseJSON && error.responseJSON.errors) {
                    let responseJSON = error.responseJSON.errors ;
                    for (let key in responseJSON) {
                        $('.' + key + '_error').text(responseJSON[key][0]);
                    }
                } else {
                    // Xử lý khi không có dữ liệu lỗi được trả về
                    console.error("Error occurred, but no error data returned.");
                }
            }

        })
    })
    function hideEmailMiddle(email) {
        if (email.length <= 8) {
            return email; 
        }

        var visiblePart = email.substring(0, 4); 

        var middlePartLength = email.length - 8;
        var hiddenPart = '*'.repeat(middlePartLength);

        visiblePart += hiddenPart; 

        visiblePart += email.substring(email.length - 4); 

        return visiblePart;
    }


    function addNewComment(response) {
        let email = hideEmailMiddle(response.email);       

        let newCommentHTML = '<div class="my-2 row">'+
                                '<div class="col-4">' +
                                    '<span style="font-weight:500;font-size:19px;color:#86B817;">' + email + '</span> <br>' + 
                                    '<span style="font-size:14px ;">'+ response.date_comment +'</span>' +
                                '</div>' +
                                '<div class="col-8 mt-1">' +
                                    '<span style="font-weight:400;font-size:16px;">'+ response.content_comment +'</span> <br>' +
                                '</div>' +
                             '</div>' ;
        $('.content-item-comments').prepend(newCommentHTML) ;
    }
})
$('.btn-show-more-ratings').on('click' , function(){
    $('.content-item-ratings').css({
        "height" : "auto" ,
    }) ;
    $('.btn-hidden-ratings').css({
        "display" : "block" ,
    }) ;
    $('.btn-show-more-ratings').css({
        "display" : "none" ,
    }) ;
}) ;
$('.btn-hidden-ratings').on('click' , function(){
    $('.content-item-ratings').css({
        "height" : "180px" ,
    }) ;
    $('.btn-hidden-ratings').css({
        "display" : "none" ,
    }) ;
    $('.btn-show-more-ratings').css({
        "display" : "block" ,
    }) ;
})
$('.btn-show-more-comments').on('click' , function(){
    $('.content-item-comments').css({
        "height" : "auto" ,
    }) ;
    $('.btn-hidden-comments').css({
        "display" : "block" ,
    }) ;
    $('.btn-show-more-comments').css({
        "display" : "none" ,
    }) ;
}) ;
$('.btn-hidden-comments').on('click' , function(){
    $('.content-item-comments').css({
        "height" : "180px" ,
    }) ;
    $('.btn-hidden-comments').css({
        "display" : "none" ,
    }) ;
    $('.btn-show-more-comments').css({
        "display" : "block" ,
    }) ;
})