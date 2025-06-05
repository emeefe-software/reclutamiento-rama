export default class Loader{
    constructor(){
        document.body.innerHTML += '<div class="loader-layer align-items-center d-flex justify-content-center">'+
            '<div class="text-center">'+
                '<h1 class="loader-title">¡Atención!</h1><br>'+
                '<h3 class="loader-msg">El formulario se esta enviando</h3><br>'+
                '<div class="loader-icon fa-5x"><i class="fas fa-circle-notch fa-spin"></i></div>'+
            '</div>'+
        '</div>'

        this._loaderElement = document.getElementsByClassName('loader-layer')[0];
        this._titleElement = this._loaderElement.querySelector('.loader-title');
        this._messageElement = this._loaderElement.querySelector('.loader-msg');
    }

    hide(){
        this._loaderElement.classList.remove('showing')
    }

    show(title, msg){
        this._titleElement.innerHTML = title
        this._messageElement.innerHTML = msg
        this._loaderElement.classList.add('showing')
    }
}