function deleteExcess(id){
    if (confirm("Opravdu smazat?")) {
        $.ajax({
            url: "excess",
            method: "POST",
            data: {
                deleteId: id,
            },
            success:function (data){
                $("#search_result").html(data);
            }
        });
    } else {
    }
}

function updateExcess(){
    var quantityUpdate = $('#quantity').val();
    var orderId = $('#orderId').val();
    $.ajax({
        url: "excess",
        method: "POST",
        data: {
            quantityUpdate: quantityUpdate,
            orderId: orderId
        },
        success:function (data){
            $("#search_result").html(data);
        }
    });
}
/* Vypnuti tlacitka enter na add excess u inputu ID */
$('#idExcess').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});

