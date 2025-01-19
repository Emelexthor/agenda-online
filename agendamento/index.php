<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Institucional</title>
    <!-- Incluir o Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>
        <section id="quem-somos" class="container my-5">
            <h2>Quem Somos</h2>
            <p>
                Somos uma equipe de catering comprometida em oferecer serviços de alta qualidade, personalizados para atender às necessidades dos nossos clientes.
            </p>
            <div class="media">
                <img src="./img/quem.jpeg" width="300" alt="Equipe de catering" class="mr-3">
            </div>
        </section>

        <section id="o-que-fazemos" class="container my-5">
            <h2>O Que Fazemos</h2>
            <p>
                Oferecemos serviços de catering para eventos corporativos e outras ocasiões especiais. Nosso objetivo é criar experiências inesquecíveis.
            </p>
            <div class="media">
                <img src="./img/mesa.jpg" width="300px" alt="Mesa de catering" class="mr-3">
                <video controls>
                    <source src="./videos/o-que-fazemos.mp4" type="video/mp4">
                    Seu navegador não suporta vídeos.
                </video>
            </div>
        </section>

        <section id="nosso-atendimento" class="container my-5">
            <h2>Qual o Nosso Atendimento</h2>
            <p>
                Trabalhamos com uma equipe qualificada para garantir atendimento ágil e eficiente, sempre priorizando a satisfação dos nossos clientes.
            </p>
            <div class="media">
                <img src="./img/atendimento.jpeg" alt="Atendimento ao cliente" class="mr-3">
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Incluir os scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
