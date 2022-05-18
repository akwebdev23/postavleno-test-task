console.dir('app');
const GET_ACTION = '/api/redis/';
const DELETE_ACTION = '/api/redis/';

async function sendRequest($action, $method){
    return fetch($action, {
        method: $method
    })
    .then(response=>{
        console.dir(response);
        return response.json();
    })
}
async function getAndRender(action){
    sendRequest(action, 'GET').
    then((response)=>{
        console.dir(response);
        if(response.status) 
            renderItems(response.data, '.redis-list');
        else 
            console.dir(response);
    });
}
async function deleteHandler(event){
    event.preventDefault();
    console.dir(event.target.parentElement);
    let key = event.target.parentElement.textContent.split(':')[0];
    console.dir(key);
    sendRequest(DELETE_ACTION+key,'DELETE').
    then(response=>{
        getAndRender(GET_ACTION);
    });
}
function setDeleteHandlers(){
    let removeActions = document.querySelectorAll('.remove');
    removeActions.forEach(element => {
        element.addEventListener('click', deleteHandler);
    });
}
function renderItems (items, root, clear = true){
    let renderRoot = document.querySelector(root);
    if(items){
        console.dir(renderRoot);
        if(clear)
            renderRoot.innerHTML = '';
        for(let itemKey in items){
            let li = document.createElement('li');
            li.innerHTML = `${itemKey}: ${items[itemKey]} <a class="remove">delete</a>`;
            renderRoot.append(li);
            console.dir(itemKey);
            console.dir(items[itemKey]);
        }
        setDeleteHandlers();
    } else
        renderRoot.innerText = 'Здесь скоро что то повится...'
}
getAndRender(GET_ACTION);
