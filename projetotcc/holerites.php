<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visualização de Holerite</title>
    <link rel="stylesheet" href="css/holerites.css">
    <style>
        /* Estilos adicionais para o iframe */
        #pdf-viewer {
            display: none;
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%; /* Defina a largura desejada */
            height: 70vh; /* Defina a altura desejada */
            border: none;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <h1>Ano Referência 2023</h1>
    <ul id="holerite-list">
        <li class="month-box"><a href="uploads/Modelo_Holerite_Janeiro.pdf">Janeiro</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Fevereiro.pdf">Fevereiro</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Março.pdf">Março</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Abril.pdf">Abril</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Maio.pdf">Maio</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Junho.pdf">Junho</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Julho.pdf">Julho</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Agosto.pdf">Agosto</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Setembro.pdf">Setembro</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Outubro.pdf">Outubro</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Novembro.pdf">Novembro</a></li>
        <li class="month-box"><a href="uploads/Modelo_Holerite_Dezembro.pdf">Dezembro</a></li>
    </ul>
    <button id="btn-voltar" class= "btn" onclick="voltarParaPaginaUser()">Voltar</button>
    <iframe id="pdf-viewer"></iframe>

    <script>
        const holeriteList = document.getElementById('holerite-list');
        const pdfViewer = document.getElementById('pdf-viewer');

        holeriteList.addEventListener('click', function (event) {
            event.preventDefault();
            const target = event.target;

            if (target.tagName === 'A') {
                const pdfUrl = target.getAttribute('href');
                pdfViewer.src = pdfUrl;
                pdfViewer.style.display = 'block';
            }
        });
        // Função para voltar para a página do usuário
    function voltarParaPaginaUser() {
        window.location.href = 'page_user.php';
    }
    </script>
</body>
</html>
