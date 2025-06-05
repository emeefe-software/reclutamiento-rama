export function capitalizeWords(textForCapitalize){
    let words = textForCapitalize.toLowerCase().split(' ');

    for (let i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].substring(1);     
    }

    return words.join(' ');
}

export function isNameCharacterCode(characterCode){
    let minAsciiCodeForUpperCase = 65
    let maxAsciiCodeForUpperCase = 90
    let minAsciiCodeForLowerCase = 97
    let maxAsciiCodeForLowerCase = 122
    let extraKeyCodes = [8,32,180,209,241,225,233,237,243,250]

    if(((characterCode >= minAsciiCodeForUpperCase && characterCode <= maxAsciiCodeForUpperCase)
        || (characterCode >= minAsciiCodeForLowerCase && characterCode <= maxAsciiCodeForLowerCase) 
        || (characterCode >= 160 && characterCode <= 165) //áíóúñÑ
        || extraKeyCodes.includes(characterCode))){
        return true;
    }
}

/**
 * Validar números del 0 al 9
 * 
 * @param {int} characterCode 
 */
export function isValidSimplePhoneCharCode(characterCode){
    return characterCode >= 48 && characterCode <= 57;
}