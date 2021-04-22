var allBooks = []
function search(){
    $("#results").remove();
    $("#notfound").remove();
    var toSearch = $("#search").val();
    var filter = $("#filter").val();
    var found = []
    var count = 0;
    if(filter == "Title"){
        for(var i=0; i<allBooks.length; i++){
            if(allBooks[i][1].includes(toSearch)){
                found[count] = allBooks[i];
                count++;
            }
        }
    }else{
        if(filter == "Author"){
            for(var i=0; i<allBooks.length; i++){
                if(allBooks[i][2].includes(toSearch)){
                    found[count] = allBooks[i];
                    count++;
                }
            }
        }
    }
    if(found.length > 0){
        var array = '<table id="results" class="table"><thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Title</th><th scope="col">Author</th><th scope="col">Action</th></tr></thead><tbody id="array">'
        for(var i=0; i<found.length; i++){
            array += '<tr id="cell'+(i+1)+'"><th scope="row">'+(i+1)+'</th><td>'+found[i][1]+'</td><td>'+found[i][2]+'</td><td><button id="id" name="id" class="btn btn-warning" onclick="access(\''+found[i][0]+'\')" type="submit">Access</button></td></tr>';
        }
        array += "</tbody></table>";
    }else{
        array = "<div id='notfound' class='col-12 text-center'>No books were found. <a target='_blank' href='https://www.google.fr/search?source=hp&ei=pBPiX4zmLsusa5GLn8AG&q=amazon+"+toSearch.replace(" ","+")+"&oq=amazon+"+toSearch.replace(" ","+")+"&gs_lcp=CgZwc3ktYWIQA1AAWABguAVoAHAAeACAAQCIAQCSAQCYAQCqAQdnd3Mtd2l6&sclient=psy-ab&ved=0ahUKEwiMyPPB9uHtAhVL1hoKHZHFB2gQ4dUDCAY&uact=5"+toSearch+"'>Click</a>  here.</div>";
    }
    $("#affichage").after(array);
}

function storeBooks(books){
    for(var i=0; i<books.length; i++){
        allBooks[i] = books[i];
    }
}

function access(id){
    window.location.href="http://chall0.heroctf.fr:8050/?page=manageBook&id="+id;
}
