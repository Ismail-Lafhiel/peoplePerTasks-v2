$(document).ready(function(){
    $("#search-bar").keyup(function(){
        var input = $(this).val();
        // alert(input)

        if(input != ""){
            $.ajax({
                url: "../pages/controllers/servicesController.php",
                method: POST,
                data: {input:input},

                success: function(data){
                    $("#search-result").html(data);
                    $("#search-result").css("display", "block");
                }

            })
        }
    });
})