
function onJsonRicerca(json) {
    console.log(json);
    console.log(json.length);
    if (!json) {
        document.querySelector("article").innerHTML = "";
        const post = document.querySelector("article");
        const notFound = document.createElement("div")
        notFound.textContent = "No data."
        post.appendChild(notFound);
    }
    else {
        const art=document.querySelector("article");
        
        for (let i = 0; i < json.length; i++) {
            const article = document.querySelector("article");
            console.log(article)
            const div = document.createElement("div");
            div.classList.add("post");
            console.log(div)
            const autore = document.createElement("div");
            autore.classList.add("author");
            autore.textContent = json[i].author;
            console.log(autore)
            div.appendChild(autore);
            const titolo = document.createElement("div");
            titolo.classList.add("title");
            titolo.textContent = json[i].content.title;
            div.appendChild(titolo);
            console.log(titolo)
            const contenuto = document.createElement("div");
            contenuto.classList.add("content");
            contenuto.textContent = json[i].content.caption;
            div.appendChild(contenuto);
            console.log(contenuto)
            article.appendChild(div);
            console.log(div)

        }
    }
}

function request(event) {
    event.preventDefault();
    const query = document.querySelector("#search").value; 
    if (query) fetch("fetch_post.php?search=" + encodeURIComponent(query)).then(onResponse).then(onJsonRicerca);
    else { 
        document.querySelector("article").innerHTML = ""; 
        const empty = document.createElement("div"); 
        empty.classList.add("search_error"); 
        empty.textContent = "Scrivi qualcosa"; 
        const article = document.querySelector("article"); 
        article.appendChild(empty); 
    }  
}

function onJson(json){
    console.log(json);
    console.log(json.length)
    for(let i = 0;i<json.length;i++){
        const article= document.querySelector("article");
        const div = document.createElement("div");
        div.classList.add("post");
        //article.appendChild(div);
        const titolo = document.createElement("div");
        titolo.classList.add("titolo");
        titolo.textContent = json[i].content.title;
        div.appendChild(titolo);
        const autore = document.createElement("div");
        autore.classList.add("author");
        autore.textContent = json[i].author;
        div.appendChild(autore);
        const contenuto = document.createElement("div");
        contenuto.classList.add("content");
        contenuto.textContent = json[i].content.caption
        div.appendChild(contenuto)
        article.appendChild(div);


    }
}

function onResponse(response){
    return response.json();
}

fetch("fetch_post.php?posts=all").then(onResponse).then(onJson);



const form_r=document.querySelector('#wiki');
form_r.addEventListener('submit', request);