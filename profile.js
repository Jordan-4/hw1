function deletePost(event){
    fetch("delete_post.php?q=" + event.currentTarget.dataset.postId);
    const toDelete = event.currentTarget.parentNode.parentNode;
    toDelete.remove();
}

function onJson(json){
    console.log(json);
    console.log(json.length)
    for(let i = 0;i<json.length;i++){
        const article= document.querySelector("article");
        const div = document.createElement("div");
        div.classList.add("post");
        const autore = document.createElement("div");
        autore.classList.add("author");
        autore.textContent = json[i].author;
        div.appendChild(autore);
        const titolo = document.createElement("div");
        titolo.classList.add("title");
        titolo.textContent = json[i].content.title;
        div.appendChild(titolo);
        const contenuto = document.createElement("div");
        contenuto.classList.add("content");
        contenuto.textContent = json[i].content.caption;
        div.appendChild(contenuto);
        const pageDeleteContent = document.createElement('div');
            pageDeleteContent.classList.add('delete_content');
            div.appendChild(pageDeleteContent);
            const pageDelete = document.createElement('button');
            pageDelete.classList.add('delete');
            pageDelete.textContent = "Elimina post";
            pageDelete.dataset.postId = json[i].Post_id;
            pageDeleteContent.appendChild(pageDelete);
        article.appendChild(div);

        const deleteButtons = document.querySelectorAll('.delete');
            for (const deleteButton of deleteButtons){
            deleteButton.addEventListener('click',deletePost);
            }


    }
}

function onResponse(response){
    return response.json();
}

fetch("fetch_post.php?posts=mine").then(onResponse).then(onJson);