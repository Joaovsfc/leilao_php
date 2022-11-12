function mensagemErro(mensagem){
    alert(mensagem);
    exit;
} 

function validaDigitacaoArremate(){
    var inputArremate = document.getElementById('arremate').checked;
    var inputValorArremate = document.getElementById('valorArremate');
    if(inputArremate){
        inputValorArremate.readOnly = false;
    }else{
        inputValorArremate.readOnly = true; 
        inputValorArremate.value = null;
    }
} 

function teste(){
    alert('hello word');
}
