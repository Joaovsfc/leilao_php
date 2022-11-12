function validarSenha(){
    var inputSenha = document.getElementById('senha').value;
    var inputContraSenha = document.getElementById('senha2').value;
    if ((inputSenha != '' & inputContraSenha != '') & (inputContraSenha != inputSenha)){
        alert('Por favor confirmar as senhas.');
        document.getElementById("senha2").focus();
    }
    return
    
}