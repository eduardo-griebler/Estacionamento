const valores = document.querySelectorAll(".valor-atual");

const valorHora = 4.5;

function atualizarValores() {
  valores.forEach((celula) => {
    // Obtém a data de entrada do veículo
    const valorEntrada = celula.dataset.entrada;

    if (!valorEntrada) return;

    // Converte a data do MySQL para o JavaScript
    const entrada = new Date(valorEntrada.replace(" ", "T"));

    if (Number.isNaN(entrada.getTime())) return;

    // Obtém a data e hora atuais
    const agora = new Date();

    // Calcula o tempo decorrido em minutos completos
    const totalMinutos = Math.max(0, Math.floor((agora - entrada) / 60000));

    // Converte os minutos para horas e minutos
    const horas = Math.floor(totalMinutos / 60);
    const minutos = totalMinutos % 60;

    // Formata o tempo em HH:MM
    const tempoFormatado =
      String(horas).padStart(2, "0") + ":" + String(minutos).padStart(2, "0");

    // Calcula o valor por hora iniciada
    const horasCobradas = Math.max(1, Math.ceil(totalMinutos / 60));

    const valorTotal = horasCobradas * valorHora;

    // Formata o valor em reais
    const valorFormatado = valorTotal.toLocaleString("pt-BR", {
      style: "currency",
      currency: "BRL",
    });

    // Atualiza o valor na tabela
    celula.textContent = valorFormatado;

    // Atualiza as horas decorridas na mesma linha
    const linha = celula.closest("tr");

    if (linha && linha.cells[5]) {
      linha.cells[5].textContent = tempoFormatado;
    }
  });
}

// Executa imediatamente ao carregar a página
atualizarValores();

// Atualiza automaticamente a cada segundo
setInterval(atualizarValores, 1000);
