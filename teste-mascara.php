<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" >
        <div>
            <label for="">Cartão de crédito</label>
            <input type="text" 
                data-mask="#### #### #### ####" 
                data-key-accept="number"
                pattern="([0-9]{4}\s){3}[0-9]{4}"/>
        </div>
        <div>
            <label for="">Telefone DDD</label>
            <input type="text" data-mask="(##) ####-####" 
                pattern="^\([0-9]{2}\)\s[0-9]{4}-[0-9]{4}"/>
            <input type="text" data-mask="(##) ####-####" 
                pattern="^\([0-9]{2}\)\s[0-9]{4}-[0-9]{4}"/>
        </div>
        <div>
            <label for="">Telefone</label>
            <input type="text" data-mask="####-####" 
                pattern="[0-9]{4}-[0-9]{4}"/>
        </div>

        <div>
            <label for="">Celular</label>
            <input type="text" data-mask="(##) # ####-####" 
                pattern="\([0-9]{2}\)\s[0-9]{1}\s[0-9]{4}-[0-9]{4}"/>
        </div>
        <div>
            <label for="">CPF</label>
            <input type="text" data-mask="###.###.###-##"
                pattern="([0-9]{3}\.){2}[0-9]{3}-[0-9]{2}"/>
        </div>
        <div>
            <label for="">CEP</label>
            <input type="text" data-mask="##.###-###" 
                pattern="[0-9]{2}.[0-9]{3}-[0-9]{3}"/>
        </div>
        <div>
            <label for="">Data</label>
            <input type="text" data-mask="##/##/####" 
                pattern="([1-3][0-9])/([0-1][0-2])/([0-9]{4})"/>
        </div>
        <div>
            <label for="">Data dia mês</label>
            <input type="text" data-mask="##/##" 
                pattern="([1-3][0-9])/([0-1][0-2])"
                min="1" max="31"/>
        </div>

        <div>
            <label for="">Data hora</label>
            <input type="text" data-mask="##/##/#### ##:##:##" 
                pattern="([1-3][0-9])/([0-1][0-2])/([0-9]{4})\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]"/>
        </div>

        <div>
            <label for="">Hora com segundos</label>
            <input type="text" data-mask="##:##:##" 
                pattern="[0-6]{2}:[0-6]{2}:[0-6]{2}"/>
        </div>

        <div>
            <label for="">Hora</label>
            <input type="text" data-mask="##:##" 
                pattern="[0-6]{2}:[0-6]{2}" />
        </div>
        
    </form>
</body>
</html>
<script>

    configMask()
    
    function configMask() {
        
        inputs = document.querySelectorAll("input[data-mask]")
        inputWithMask = []
        for (i=0; i < inputs.length; i++) {
            var input = inputs[i]
            mask = input.dataset.mask
            maskLength = mask.length
            input.maxLength = maskLength
            

            var marks = []
            ultimo = false
            for(var j=0; j<mask.length;j++) {
                if (mask[j] !== "#") {
                    obj = {};
                    obj[j] = mask[j]
                    
                    if (!ultimo)
                        marks.push(obj)
                    else
                        marks[marks.length-1][indexUltimo] = marks[marks.length-1][indexUltimo]+mask[j]

                    ultimo = true
                    if (!indexUltimo) indexUltimo = j
                } else {
                    ultimo = false
                    indexUltimo = false
                }
            }

            //inputWithMask.push({'input':input, 'marks':marks})
            inputWithMask[input.dataset.mask] = marks

            input.addEventListener('keydown', function (e) {
               return teste3(e, this, inputWithMask)
            })
        }
    }

    /**
     * numbers
     */
    function verifyKey(keyCode, shiftKey) {

        if ((keyCode >= 65 && keyCode <= 90)) {
            return "letter"
        } else if (shiftKey && keyCode >= 48 && keyCode <= 57) {
            return "special"
        } else if (keyCode >= 48 && keyCode <= 57) {
            return "number"
        } else if (keyCode >= 106 && keyCode <= 111) {
            return "operators"
        } else if ((keyCode >= 186 && keyCode <= 222) || 
                (keyCode == 173) ||
                (keyCode == 176) ||
                (keyCode == 59)) {
            return "punctuation"
        } else if (keyCode == 32) {
            return "space"
        } else if (keyCode == 46 && keyCode == 8) {
            return "delete"
        }

        //(e.keyCode >= 58 && e.keyCode <= 64)         
    }

    function teste3(e, input, inputWithMask) {
        console.log(e.keyCode)
        if (e.keyCode == 46) return

        // if (input.dataset.keyAccept == "numbers" && (
        //         (e.keyCode >= 65 && e.keyCode <= 90) || // a-z
        //         (e.shiftKey && e.keyCode >= 48 && e.keyCode <= 57) ||
        //         (e.keyCode >= 58 && e.keyCode <= 64) ||
        //         (e.keyCode >= 106 && e.keyCode <= 111) ||
        //         (e.keyCode == 173) ||
        //         (e.keyCode == 176) ||
        //         (e.keyCode >= 186 && e.keyCode <= 222))
        //         ) {
        //     e.preventDefault()
        //     return false
        // }

        if (input.dataset.keyAccept != verifyKey(e.keyCode, e.shiftKey)) {
            e.preventDefault()
            return false
        }
        var marks = inputWithMask[input.dataset.mask]

        // if (typeof proxChar !== 'undefined' && proxChar != null && e.keyCode != 8) {
        //     ultimo = input.value.substring(input.value.length-1, input.value.length)
        //     resto = input.value.substring(0, input.value.length-1)
        //     input.value = resto + proxChar + ultimo
        //     proxChar = null
        // } else {
        //     proxChar = null
        // }

        valueLength = input.value.length

        if (e.keyCode != 8) {
            for (index in marks) {
                if (marks[index][valueLength]){
                    console.log(marks[index][valueLength])
                    input.value = input.value + marks[index][valueLength]
                }
            }
        } else {
            for (index in marks) {
                if (marks[index][valueLength]){
                    console.log(marks[index][valueLength])
                    proxChar = marks[index][valueLength]
                } 
            }
        }
    }

    function teste2(e) {
        //if (campo.value == "") return
        //if (e.keyCode == 8 || e.keyCode == 46) return
        if (e.keyCode == 46) return
        
        
        
        if (typeof proxChar !== 'undefined' && proxChar != null && e.keyCode != 8) {
            ultimo = campo.value.substring(campo.value.length-1, campo.value.length)
            resto = campo.value.substring(0, campo.value.length-1)
            campo.value = resto + proxChar + ultimo
            proxChar = null
        } else {
            proxChar = null
        }
        
        mask = campo.dataset.mask
        maskLength = mask.length
        campo.maxLength = maskLength
        console.log(mask)

        var marks = []
        ultimo = false
        for(var i=0; i<mask.length;i++) {
            if (mask[i] !== "#") {
                obj = {};
                obj[i] = mask[i]
                
                if (!ultimo)
                    marks.push(obj)
                else
                    marks[marks.length-1][indexUltimo] = marks[marks.length-1][indexUltimo]+mask[i]

                ultimo = true
                if (!indexUltimo) indexUltimo = i
            } else {
                ultimo = false
                indexUltimo = false
            }
        }
        
        
        valueLength = campo.value.length
        if (e.keyCode != 8) {

            for (index in marks) {
                console.log(marks[index])
                console.log(valueLength)
                //console.log(marks[index][valueLength])
                if (marks[index][valueLength]){
                    console.log(marks[index][valueLength])
                    campo.value = campo.value + marks[index][valueLength]
                } 
                
            }
        } else {
            console.log('backspace')
            console.log(valueLength-1)

            for (index in marks) {
                //console.log(marks[index][valueLength])
                if (marks[index][valueLength]){
                    console.log(marks[index][valueLength])
                    proxChar = marks[index][valueLength]
                } 
                
            }
            
    
        }
        
        console.log(marks)
    }

    function teste(input)  {
    /* inputs = document.querySelectorAll("input[data-mask]")
    input = inputs[0] */
    if (campo.value == "") return
    
    
    mask = campo.dataset.mask
    maskLength = mask.length
    console.log(mask)

    var point = [];
    var hifen = [];
    var bar = [];
    for(var i=0; i<mask.length;i++) {
        if (mask[i] === ".") point.push(i);
        if (mask[i] === "-") hifen.push(i);
        if (mask[i] === "/") bar.push(i);
    }
    console.log(point)
    console.log(hifen)
    console.log(bar)
        
    for (i in point) {
        left = campo.value.substring(0,point[i])
        right = campo.value.substring(point[i])
        if (right[0] == ".") {
            console.log('achou ponto')
        continue
        }
        console.log(left)
        console.log(left + "." +right)
        campo.value = left+"."+right
    }
    
    for (i in hifen) {
        left = campo.value.substring(0,hifen[i])
        right = campo.value.substring(hifen[i])
        if (right[0] == "-") {
            continue
        }
        console.log(left)
        console.log(left + "-" +right)
        campo.value = left+"-"+right
    }

        for (i in bar) {
        left = campo.value.substring(0,bar[i])
        right = campo.value.substring(bar[i])
        if (right[0] == "/") {
            continue
        }
        console.log(left)
        console.log(left + "/" +right)
        campo.value = left+"/"+right
    }

    
    }
</script>