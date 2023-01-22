$(document).ready(function(){
        $("#frm-orderForm-material_id").keyup(function()
        {
            let input = $(this).val();
            if (input !== "") {
                $.ajax({
                    url:"excess",
                    method: "POST",
                    data: {input:input},
                    success:function (data){
                        $("#search_result").html(data);
                    }
                })

            }

        });

 });
$('#frm-orderForm-order_id').bind('keypress', function(e) {
    let code = e.keyCode || e.which;
    if(code === 13) { //Enter keycode
        document.getElementById("frm-orderForm-material_id").focus();
        return false;
    }
});
$('#frm-orderForm-material_id').bind('keypress', function(e) {
    let code = e.keyCode || e.which;
    if(code === 13) { //Enter keycode
        document.getElementById("frm-orderForm-made_quantity").focus();
        return false;
    }
});