function imprimirTabela() {
    const tabelaOriginal = document.querySelector('table');
    const tabelaClone = tabelaOriginal.cloneNode(true);

    // Remover a última coluna (ações)
    const colunasAcao = tabelaClone.querySelectorAll('tr > td:last-child, tr > th:last-child');
    colunasAcao.forEach(coluna => coluna.remove());

    // Criar um container para o conteúdo a ser impresso
    const divImpressao = document.createElement('div');

    // Criar a tabela personalizada
    const tabelaImpressao = document.createElement('table');
    tabelaImpressao.style.width = '100%';
    tabelaImpressao.style.borderCollapse = 'collapse';
    tabelaImpressao.style.margin = '20px 0';

    // Estilizar a tabela
    tabelaImpressao.innerHTML = `
        <thead>
            <tr>
                <th colspan="100%" style="text-align: center; font-size: 18px; padding: 10px; border: 1px solid black; background-color: #f2f2f2;">
                    EVENTOS DO DIA!
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="100%" style="text-align: center; padding: 8px; border: 1px solid black;">
                    Data de impressão: ${new Date().toLocaleDateString('pt-BR')} ${new Date().toLocaleTimeString('pt-BR')}
                </td>
            </tr>
            <tr>
                <td colspan="100%" style="padding: 0;">
                    ${tabelaClone.outerHTML}
                </td>
            </tr>
        </tbody>
    `;

    // Adicionar a tabela ao container
    divImpressao.appendChild(tabelaImpressao);

    // Abrir uma nova janela para impressão
    const janelaImpressao = window.open('', '', 'width=800,height=600');
    janelaImpressao.document.write(`
        <html>
        <head>
            <title>Impressão</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
            ${divImpressao.innerHTML}
        </body>
        </html>
    `);
    janelaImpressao.document.close();
    janelaImpressao.print();
}


