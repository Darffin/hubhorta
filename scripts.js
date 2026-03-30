document.addEventListener('DOMContentLoaded', () => {
	const senhaInput = document.getElementById('senha');
	const gatoLogo = document.getElementById('gato');
	
	atualizarCarrinho();
	senhaInput.addEventListener('focus', () => {
		gatoLogo.src = '/web-petshop/images/1.gif';
	});
    
	senhaInput.addEventListener('blur', () => {
		gatoLogo.src = '/web-petshop/images/2.gif';
	});
});


function adicionarAoCarrinho(idProduto,q) {
    //const quantidade = document.getElementById('quantidade_' + idProduto).value;

    fetch('/web-petshop/carrinho/insere_carrinho.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${idProduto}&q=${q}`
    })
    .then(response => response.text())
    .then(data => {
        atualizarCarrinho();
        //document.getElementById('feedback_' + idProduto).innerText = 'Adicionado!';
        setTimeout(() => {
            //document.getElementById('feedback_' + idProduto).innerText = '';
        }, 2000);
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}

function removerDoCarrinho(idProduto) {
    //const quantidade = document.getElementById('quantidade_' + idProduto).value;

    fetch('/web-petshop/carrinho/remove_carrinho.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${idProduto}`
    })
    .then(response => response.text())
    .then(data => {
        atualizarCarrinho();
        //document.getElementById('feedback_' + idProduto).innerText = 'Adicionado!';
        setTimeout(() => {
            //document.getElementById('feedback_' + idProduto).innerText = '';
        }, 2000);
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}

function atualizarContagem() {
    fetch('/web-petshop/carrinho/contagem_carrinho.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('contagem-carrinho').innerHTML = html;
        })
        .catch(error => {
            console.error("Erro ao atualizar carrinho:", error);
        });
}

function atualizarCarrinho() {
    fetch('/web-petshop/carrinho/carrinho.php?nocache=' + new Date().getTime())
        .then(response => response.text())
        .then(html => {
            document.getElementById('sidebar-carrinho').innerHTML = html;
            atualizarContagem();
        })
        .catch(error => {
            console.error("Erro ao atualizar carrinho:", error);
        });
}


function abrirCarrinho() {
  document.getElementById("sidebar-carrinho").classList.add('aberta');
}

function fecharCarrinho() {
  document.getElementById("sidebar-carrinho").classList.remove('aberta');
}

function salvaPedido($id) {

    var id = $id;

    if(id==null || id == "" || id == undefined) {
        inserePedido();
    } else {
        alteraPedido();
    }
}

function inserePedido(id_usuario, valor_total) {

    var pedido = {
        id_usuario: id_usuario,
        valor_total: valor_total
    };

$.ajax({
    url: "/web-petshop/pedido.php",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify(pedido),
    success: function(res) {

    },
    error: function(xhr) {
        const resposta = xhr.responseJSON;
        Swal.fire({
            icon: "error",
            title: "Erro ao realizar pedido",
            customClass: {popup: 'pop-up'},
            text: resposta?.erro || "Erro inesperado!"
        });
    }
});


}


function buscarPedidos() {
    fetch('/web-petshop/pedido.php')
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao buscar pedidos");
            }
            return response.json();
        })
        .then(pedidos => {
            console.log("Pedidos encontrados:", pedidos);
            // talvez document.getElementById("listaPedidos").innerText = JSON.stringify(pedidos, null, 1); ? 
        })
        .catch(error => {
            console.error("Erro:", error);
        });
}
