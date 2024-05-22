$(document).ready(function() {
    $('#form-add-rating').on('submit' , function(event) {
        event.preventDefault() ;

        let rating = $('input[name="rating"]').val() ;
        let content_rating = $('textarea[name="content_rating"]').val() ;
        let _token = $(this).find('input[name="_token"]').val() ;
        let url = $(this).attr('action') ;

        $('.rating-error').text('') ;

        $.ajax({
            url : url ,
            type : "POST" ,
            data : {
                rating : rating ,
                content_rating : content_rating ,
                _token : _token ,
            } ,
            dataType : 'json' ,
            success : function(response) {
                addNewRating(response.data) ;
                $('#form-add-rating')[0].reset();
                $('.btn-close').click() ;

                $('.btn-rating').css({
                    "display" : "none" 
                }) ;
            } ,
            error : function(error) {
                if(error.responseJSON && error.responseJSON.errors) {
                    let responseJSON = error.responseJSON.errors ;
                    for (let key in responseJSON) {
                        $('#' + key + '_error').text(responseJSON[key][0]);
                    }
                }else {
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

    function addNewRating(response) {
        let email = hideEmailMiddle(response.email); 

        let countStars = '' ;

        for(let i = 0 ; i < response.rating ; i++) {
            countStars += '<span class="star-rating" style="margin-right:4px;"><i class="fa-solid fa-star"></i></span>' ;
        }

        let newRatingHTML = '<div class="my-1 row">'+
                                '<div class="col-4">' +
                                    '<span style="font-weight:500;font-size:19px;color:#86B817;">' + email + '</span> <br>' + 
                                    '<span style="font-size:14px ;">'+ response.date_rating +'</span>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<span style="font-weight:400;font-size:16px;">'+ response.content_rating +'</span> <br>' +
                                '</div>' +
                                '<div class="col-2">' +
                                    countStars +
                                '</div>' +
                             '</div>' ;
        $('.content-item-ratings').prepend(newRatingHTML) ;
    }
    
})
