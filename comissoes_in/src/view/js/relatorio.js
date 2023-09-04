$(document).ready(function () {
  $('#filtroBtn').click(function () {
    atualizarRelatorio();
  });

  function atualizarRelatorio() {
    var dataInicio = $('#data_inicio').val();
    var dataFim = $('#data_fim').val();

    $.ajax({
      url: '/comissoes_in/src/model/relatorio.php',
      type: 'POST',
      dataType: 'json',
      data: {
        dataInicio: dataInicio,
        dataFim: dataFim
      },
      success: function (response) {
        console.log(response);
        exibirRelatorio(response);
      },
      error: function (x) {
        console.log(x);
        console.log('Erro ao carregar relatório.');
      }
    });
  }

  function exibirRelatorio(response) {
    var tabela = $('#relatoriopagamento tbody');
    tabela.empty();

    var grupos = {};

    response.forEach(function (comissao) {
      var nomeVendedorIndicacao = comissao.NOME_VENDED_INDICACAO;

      if (!grupos[nomeVendedorIndicacao]) {
        grupos[nomeVendedorIndicacao] = 0;
      }

      grupos[nomeVendedorIndicacao] += parseFloat(comissao.VALOR_DA_COMISSAO);
    });

    for (var nomeVendedor in grupos) {
      var valorTotal = grupos[nomeVendedor];

      var row = $('<tr></tr>');
      var cellNomeVendedor = $('<td></td>').text(nomeVendedor);
      var cellValorTotal = $('<td></td>').text(valorTotal.toFixed(2));

      row.append(cellNomeVendedor)
        .append(cellValorTotal);

      tabela.append(row);
    }
  }
});
