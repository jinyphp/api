
function apicall(action)
{
    $.ajax({
        type: "POST",
        url: "/",
        dataType: "json",
        data: JSON.stringify({ 
            Name: "jiny", 
            Credits: "1234" 
        }),
        contentType: "application/json",
        beforeSend : function(xhr){
            xhr.setRequestHeader("ApiKey", "asdfasxdfasdfasdf");
        },
        success : function(data, status, xhr) { 
            console.log(data); 
            $('#username').html(data.Name);
        },
        error: function(jqXHR, textStatus, errorThrown) { 
            console.log(jqXHR.responseText); 
        }
    });
}
