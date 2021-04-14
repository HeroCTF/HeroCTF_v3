var allBooks = new Array();
var maxPage = 0;

function storeBooks(books){
    for(var i=0; i<books.length; i++){
        allBooks[i] = books[i];
    }
}

function storeMaxPage(mp){
    maxPage = mp;
}

function changePage(){
    var selectedPage = $('#nbPage option:selected').text();
    modifyArrow(selectedPage);
    var end = selectedPage*10;
    var begin = end-10;
    var toAppend = [];
    for(var j=1;j<=10;j++){
        $("#cell"+j).remove();
    }
    j=1
    for(var i=begin;i<end;i++){
        var hbr = "No.";
        if(allBooks[i][4] == 1) hbr = "Yes.";
        $('#array').append('<tr id="cell'+j+'"><th scope="row">'+(i+1)+'</th><td>'+allBooks[i][1]+'</td><td>'+allBooks[i][2]+'</td><td>'+hbr+'</td><td>'+allBooks[i][5]+'</td><td><button type="submit" name="'+allBooks[i][0]+'" class="btn btn-warning">Modify</button></td>');
        j++;
    }
}

function modifyArrow(sp){
    if(sp == maxPage) $("#next").remove();
    if(sp == 1){
         $("#before").remove();
         if($('#next').length == 0){
             $('#nbPage').after('<a href="#" id="next" onclick="changePage();">>>></a>');
         }
    }
    if(sp != 1){
        if($('#before').length == 0){
            $('#nbPage').before('<a href="#" id="before" onclick="changePage();"><<<</a>');
        }
    }
}