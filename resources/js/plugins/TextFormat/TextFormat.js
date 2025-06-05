import {
    capitalizeWords,
    isNameCharacterCode,
    isValidSimplePhoneCharCode
} from './helpers'

const TextFormat = {
    install(Vue, options) {
        // 1. add global method or property
        Vue.myGlobalMethod = function () {
        // some logic ...
        }
    
        Vue.directive('format-capitalize-words', {
            bind (element, binding, vnode, oldVnode) {
                element.addEventListener("keyup", ()=>{
                    let textForCapitalize = element.value
                    let textCapitalized = capitalizeWords(textForCapitalize)
                    element.value = textCapitalized
                });
            }
        })

        Vue.directive('format-name', {
            bind (element, binding, vnode, oldVnode) {
                element.addEventListener("keyup", ()=>{
                    let textForCapitalize = element.value
                    let textCapitalized = capitalizeWords(textForCapitalize)
                    element.value = textCapitalized
                });

                element.addEventListener("keypress", (event)=>{
                    if(!isNameCharacterCode(event.charCode)){
                        event.preventDefault();
                    }
                })
            }
        })


        Vue.directive('format-simple-phone', {
            bind (element, binding, vnode, oldVnode) {
                element.addEventListener("keypress", (event)=>{
                    if(!isValidSimplePhoneCharCode(event.charCode)){
                        event.preventDefault();
                    }

                    if(element.value.replace(/\s/g,'').length==10){
                        event.preventDefault();
                    }
                })
            }
        })

        
    
        // 3. inject some component options
        Vue.mixin({
        created: function () {
            // some logic ...
        }
        
        })
    
        // 4. add an instance method
        Vue.prototype.$myMethod = function (methodOptions) {
        // some logic ...
        }
    }
}

export default TextFormat;