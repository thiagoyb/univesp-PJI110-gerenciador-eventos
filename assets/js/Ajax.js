class Ajax{
    static get (url, params={}){
        return Ajax.request('GET', url, params);
    }
    static post (url, params={}){
        return Ajax.request('POST', url, params);
    }
    static put (url, params={}){
        return Ajax.request('PUT', url, params);
    }
    static delete (url, params={}){
        return Ajax.request('DELETE', url, params);
    }

    static request(method, url, params={}){
        return new Promise((resolve, reject)=>{
            let ajax = new XMLHttpRequest();
            ajax.open(method.toUpperCase(), url);
            ajax.onerror = event =>{
                reject(event);
            }
            ajax.onload = event =>{
                let objReturn = {};
                try{
                    objReturn = JSON.parse(ajax.responseText)||[];
                } catch(e){
                    reject(e);
                }
                resolve(objReturn);
            }
            ajax.setRequestHeader('Content-Type', 'application/json');
            ajax.send(JSON.stringify(params));
        });
    }
}