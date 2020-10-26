function acessoAberto() {

    var formData = {
        'nome':     $('input[name=nome_login]').val(),
        'email':    $('input[name=email_login]').val(),
        'cpf':      $('input[name=cpf_login]').val(),
        'telefone': $('input[name=tel_login]').val(),
        'type_form':     "aberto"
    }

    // process the form
    $.ajax({
        type        : 'POST', 
        url         : 'php/validacao.php', // the url where we want to POST
        data        : formData, // our data object
        dataType    : 'json', 
        encode      : true
    })
    .done(function(data) {
        
        if(data.success == "OK")
        {
            var dados = formData;  
            
            $.ajax({
                type        : 'POST', 
                url         : 'php/verifyUser.php',
                data        : dados
            })
            .done(function(data){
                
                if(data.mensagem == "Dados incorretos")
                {
                    alert(data.mensagem);                    
                }      
                else {
                    $("#forms").hide();
                    $("#areaAberta").removeAttr("hidden");
                    
                    $('#tableAberta').append('<tr><td>' + data.nome + '</td><td>' + data.email + '</td><td>' + data.cpf + '</td><td>' + data.telefone + '</td></tr>');
                }              
            });              
        }
        else {
            alert(data.mensagem);
        }           
    });   
};

function acessoRestrito() {

    var formData = {
        'nome':     $('input[name=nome_cad]').val(),
        'email':    $('input[name=email_cad]').val(),
        'cpf':      $('input[name=cpf_cad]').val(),
        'senha':    $('input[name=senha_cad]').val(),
        'type_form':     "restrito"
    }

    // process the form
    $.ajax({
        type        : 'POST', 
        url         : 'php/validacao.php', // the url where we want to POST
        data        : formData, // our data object
        dataType    : 'json', 
        encode      : true
    })
    .done(function(data) {
        
        if(data.success == "OK")
        {
            var dados = formData;  
            
            $.ajax({
                type        : 'POST', 
                url         : 'php/verifyUser.php',
                data        : dados
            })
            .done(function(data){
                
                if(data.mensagem == "Dados incorretos")
                {
                    alert(data.mensagem);                    
                }      
                else {

                    $.ajax({
                        type        : 'POST', 
                        url         : 'php/dbActions.php',
                        data        : {'action': 'select'}
                    })
                    .done(function(data) {

                        $("#forms").hide();
                        $("#areaRestrita").removeAttr("hidden");
                        
                        var array = data.dados_restrito;

                        for(var i = 0; i < data.total_restrito; i++)
                        {
                            $('#tableRestrita').append('<tr><td hidden id="idR-' + i + '">' + 
                            array[i].id + '</td><td contenteditable="true" id="nomeR-' + i + '">' + 
                            array[i].nome + '</td><td contenteditable="true" id="emailR-' + i + '">' + array[i].email + 
                            '</td><td contenteditable="true" id="cpfR-' + i + '">' + array[i].cpf + '</td><td contenteditable="true" id="senhaR-' + i + '">' + 
                            array[i].senha + '</td><td><button type="button" onclick="salvar('+i+')" id="salvar-' + i + '">Salvar</button></td><td><button type="button" onclick="deletar('+i+')" id="excluirR-' + i + '">Excluir</button></td></tr>');
                        }   
                        
                        var array_a = data.dados_aberto;

                        for(var i = 0; i < data.total_aberto; i++)
                        {
                            $('#tableRestrita_a').append('<tr><td hidden id="idA-' + i + '">' + 
                            array_a[i].id + '</td><td contenteditable="true" id="nomeA-' + i + '">' + 
                            array_a[i].nome + '</td><td contenteditable="true" id="emailA-' + i + '">' + array_a[i].email + 
                            '</td><td contenteditable="true" id="cpfA-' + i + '">' + array_a[i].cpf + '</td><td contenteditable="true" id="telefoneA-' + i + '">' + 
                            array_a[i].telefone + '</td><td><button type="button" onclick="salvarA('+i+')" id="salvarA-' + i + '">Salvar</button></td><td><button type="button" onclick="deletarA('+i+')" id="excluirA-' + i + '">Excluir</button></td></tr>');
                        } 
                    });
                }              
            });              
        }
        else {
            alert(data.mensagem);
        }           
    });   
};

function salvarA(linha) {
    
    var formData = {
        'id': $("#idA-" + linha + "").html(),
        'nome': $("#nomeA-" + linha + "").html(),
        'email': $("#emailA-" + linha + "").html(),
        'cpf': $("#cpfA-" + linha + "").html(),
        'telefone': $("#telefoneA-" + linha + "").html(),
        'type_form': "aberto",
        'action': "update"
    }

    $.ajax({
        type        : 'POST', 
        url         : 'php/dbActions.php', // the url where we want to POST
        data        : formData, // our data object
        dataType    : 'json', 
        encode      : true
    })
    .done(function(data) {
        alert(data.mensagem);
    });
}

function salvar(linha) {

    var formData = {
        'id': $("#idR-" + linha + "").html(),
        'nome': $("#nomeR-" + linha + "").html(),
        'email': $("#emailR-" + linha + "").html(),
        'cpf': $("#cpfR-" + linha + "").html(),
        'senha': $("#senhaR-" + linha + "").html(),
        'type_form': "restrito",
        'action': "update"
    }

    $.ajax({
        type        : 'POST', 
        url         : 'php/dbActions.php', // the url where we want to POST
        data        : formData, // our data object
        dataType    : 'json', 
        encode      : true
    })
    .done(function(data) {
        alert(data.mensagem);
    });
}

function deletarA(linha) {
    
    var formData = {
        'id': $("#idA-" + linha + "").html(),
        'type_form': "aberto",
        'action': "delete"
    }

    $.ajax({
        type        : 'POST', 
        url         : 'php/dbActions.php', // the url where we want to POST
        data        : formData, // our data object
        dataType    : 'json', 
        encode      : true
    })
    .done(function(data) {
        alert(data.mensagem);
    });
};

function deletar(linha) {
    
    var formData = {
        'id': $("#idR-" + linha + "").html(),
        'type_form': "restrito",
        'action': "delete"
    }

    $.ajax({
        type        : 'POST', 
        url         : 'php/dbActions.php', // the url where we want to POST
        data        : formData, // our data object
        dataType    : 'json', 
        encode      : true
    })
    .done(function(data) {
        alert(data.mensagem);

    });
};

$(document).ready(function() {    

    $('#cpf_login').mask('000.000.000-00');
    $('#cpf_cad').mask('000.000.000-00');
    $('#tel_login').mask('(00) 0000-00009');    

    // process the form
    $('#formAberto').submit(function(event) {

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

        var formData = {
            'nome':     $('input[name=nome_login]').val(),
            'email':    $('input[name=email_login]').val(),
            'cpf':      $('input[name=cpf_login]').val(),
            'telefone': $('input[name=tel_login]').val(),
            'type_form':     "aberto",
            'action': "insert"
        }
        
        // process the form
        $.ajax({
            type        : 'POST', 
            url         : 'php/validacao.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', 
            encode      : true
        })
        .done(function(data) {
            
            if(data.success == "OK")
            {
                var dados = formData;

                $.ajax({
                    type        : 'POST', 
                    url         : 'php/dbActions.php',
                    data        : dados
                })
                .done(function(data){
                    alert(data.mensagem);                  
                });    
            }
            else {
                alert(data.mensagem);
            }           
        });        
    });

     // process the form
     $('#formRestrito').submit(function(event) {

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

        var formData = {
            'nome':     $('input[name=nome_cad]').val(),
            'email':    $('input[name=email_cad]').val(),
            'cpf':      $('input[name=cpf_cad]').val(),
            'senha':    $('input[name=senha_cad]').val(),
            'type_form':     "restrito",
            'action': "insert"
        }

        // process the form
        $.ajax({
            type        : 'POST', 
            url         : 'php/validacao.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', 
            encode      : true
        })
        .done(function(data) {
            
            if(data.success == "OK")
            {
                var dados = formData;
                
                $.ajax({
                    type        : 'POST', 
                    url         : 'php/dbActions.php',
                    data        : dados
                })
                .done(function(data){
                    alert(data.mensagem);                   
                }); 
            }
            else {
                alert(data.mensagem);
            }           
        });        
    });
});