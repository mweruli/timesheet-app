Get values from Input

// use to select with DOM element.
$("input").val();

// use the id to select the element.
$("#txt_name").val();

// use type="text" with input to select the element
$("input:text").val();
Set value to Input

// use to add "text content" to the DOM element.
$("input").val("text content");

// use the id to add "text content" to the element.
$("#txt_name").val("text content");

// use type="text" with input to add "text content" to the element
$("input:text").val("text content");

$('#add_department_id').after('<div id="bad_username" style="color:red;">' +
                    '<p>(That Username is already taken. Please choose another.)</p></div>');
                    
                    $.ajax({
        dataType: "json",
        url: "http://www.omdbapi.com/?i=tt0111161",
        success: function (data) {
            console.log(data);
            $("#movie-data").append(JSON.stringify(data));
            
var content = 'Title : '+data.Title ;
content += ' Year : '+data.Year ;
content += ' Rated : '+data.Rated ;
content += ' Released : '+data.Released ;
$("#movie-data").append(content);