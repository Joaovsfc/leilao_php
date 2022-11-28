function mensagemErroHistoryBack(mensagem){
    alert(mensagem);
    history.back(); 
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

function excluirTeste(modulo, id){
    const r = confirm("Are you sure you want to do that?");
    alert(r);
}