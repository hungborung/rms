
function getTransactions() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "http://127.0.0.1:8000/transactions",
        success: function (res, status, xhr) {
            if (res != null) {
                $("#transactions_table").empty();
                $.each(res, function (i, e) {
                    $("#transactions_table").append(`<tr id='tran-` + e.id + `'>
                    <td>` + e.id + `</td>
                    <td>` + e.wallet_id + `</td>
                    <td>` + e.type + `</td>
                    <td>` + e.amount + `</td>
                    <td>` + e.reference + `</td>
                    <td>` + e.timestamp + `</td>
                    </tr>`);
                });
            }
        },
        error: function(xhr, error){
            alert(xhr.status);
        }
    });
}

$(document).ready(function () {
    $("#CreateTransaction").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "http://127.0.0.1:8000/transactions",
            data: JSON.stringify({
                name: $("#nameTransaction").val(),
                type: $("#type").val(),
                amount: $("#amount").val(),
                reference: $("#reference").val(),
                hash_check: $("#nameTransaction").val() + $("#type").val() + $("#amount").val() + $("#reference").val()
            }),
            success: function (res, status, xhr) {
                // alert(xhr.status);
                location.reload();
            },
            error: function(xhr, error){
                console.log(xhr, error);
                // alert(xhr.status);
            }
        });
    });
})
